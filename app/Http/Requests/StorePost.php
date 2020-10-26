<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_id' => 'required|integer|exists:countries,id',
            'zipcode_id' => 'required|integer|exists:zipcodes,id',
            'gender' => 'required|string|in:male,female',
            'spoken_languages' => 'required|max:5|min:1',
            'services_offer' => 'required|min:1|max:5',
            'hourly_rate' => 'required|integer|min:0|max:100',
            'experience' => 'required|integer|max:20',
            'description' => 'required|string',
            'phone' => 'required|string|max:45',
            'profile_photo' => 'sometimes|nullable|image|max:2048|mimes:jpg,jpeg,png'.
                '|dimensions:min_width=25,min_height=25',
            'onsite_service' => 'sometimes|nullable|integer|min:0|max:1',
            'referrer_id' => 'sometimes|nullable|string|exists:referrers,id',
            'reference' => 'sometimes|nullable|string|max:45',
            'recaptcha_token' => ['required', new Recaptcha]
        ];
    }
}
