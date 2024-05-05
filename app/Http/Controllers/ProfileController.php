<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('front.profile', [
            'user' => $request->user(),
            'address' => $request->user()->shippingAddress,
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstName' => ['required','string','max:255'],
            'lastName' => ['required','string','max:255'],
            'phone' => ['required','string'],
            'postalCode' => ['required','string'],
            'country' => ['required','string'],
            'city' => ['required','string'],
        ]);

        if ($validator->passes()) {
        $user = Auth::user();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->phone = $request->phone;
            $user->shippingAddress->postalCode = $request->postalCode;
            $user->shippingAddress->country = $request->country;
            $user->shippingAddress->city = $request->city;

            $user->save();
            $user->shippingAddress->save();

        return Redirect::route('profile.edit')->with('success', 'profile updated');
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validation passed, update the password
        $user = $request->user();
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');

        // Verify the current password
        if (!\Hash::check($currentPassword, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        // Update the user's password
        $user->password = \Hash::make($newPassword);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
