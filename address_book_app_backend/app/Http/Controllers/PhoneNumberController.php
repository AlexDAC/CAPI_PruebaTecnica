<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\QueryHelper;
use App\Http\Requests\UpsertPhoneNumberRequest;
use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Repositories\phoneNumbers\ReadPhoneNumberInterface;
use App\Repositories\phoneNumbers\WritePhoneNumberInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PhoneNumberController extends Controller
{
    private writePhoneNumberInterface $writePhoneNumberInterface;
    private ReadPhoneNumberInterface $readPhoneNumberInterface;
    
    public function __construct(WritePhoneNumberInterface $writePhoneNumberInterface, ReadPhoneNumberInterface $readPhoneNumberInterface)
    {
        $this->readPhoneNumberInterface = $readPhoneNumberInterface;
        $this->writePhoneNumberInterface = $writePhoneNumberInterface;
    }

    /**
     * Create a new phone_number for the contact in the database
     * 
     * @param Contact $contact
     * @param UpsertPhoneNumberRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method POST
     * @route /api/contacts/{contact}/phone_numbers
     * @name contact_phone_numbers.store
     *
     */
    public function store(Contact $contact,UpsertPhoneNumberRequest $request)
    {
        try {
            $data = $request->validated();
            $this->writePhoneNumberInterface->store($contact, $data);
            return ApiResponse::created();
        } catch (InvalidArgumentException $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        } 
    }

    
    /**
     * Get all phone numbers associated with the contact
     *
     * @param int $contactId
     * @param Request $request
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/{contact}/phone-numbers
     * @name contact_phone_numbers.index
     * 
     */
    public function index(int $contactId, Request $request)
    {
        try {
            $queryFilters = QueryHelper::ExtractQueryFiltersFromRequest($request);
            $phoneNumbers = $this->readPhoneNumberInterface->getAll($contactId, $queryFilters);
            return ApiResponse::success(['phoneNumbers' => $phoneNumbers]);
        } catch (Exception | Error $e) {
            return ApiResponse::unprocessable(null, null, $e->getMessage());
        }
    }

    /**
     * Get a single phone number from database
     *
     * @param PhoneNumber $phoneNumber
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/phone-numbers/{email}
     * @name contact_phone_numbers.show
     *
     */
    public function show(PhoneNumber $phoneNumber)
    {
        try {
            $phoneNumber = $this->readPhoneNumberInterface->getById($phoneNumber);
            return ApiResponse::success(['phoneNumber' => $phoneNumber]);
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

     /**
     * Update the specified phone_number of the contact in storage.
     * 
     * @param PhoneNumber $phoneNumber
     * @param UpsertPhoneNumberRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method PUT
     * @route /api/contacts/phone_numbers/{phoneNumber}
     * @name contact_phone_numbers.update
     *
     */
    public function update(PhoneNumber $phoneNumber, UpsertPhoneNumberRequest $request)
    {
        try{
            $data = $request->validated();
            $this->writePhoneNumberInterface->update($phoneNumber, $data);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Delete a specified phone number of the contact in the database
     *
     * @param PhoneNumber $phoneNumber
     * 
     * @return JsonResponse $response
     *
     * @method DELETE
     * @route /api/contacts/phone_numbers/{phoneNumber}
     * @name contact_phone_numbers.destroy
     *
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        try {
            $this->writePhoneNumberInterface->delete($phoneNumber);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }
}
