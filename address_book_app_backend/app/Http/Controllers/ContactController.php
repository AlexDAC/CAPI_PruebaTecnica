<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\UpsertContactRequest;
use App\Models\Contact;
use App\Repositories\addresses\WriteAddressInterface;
use App\Repositories\contacts\ReadContactInterface;
use App\Repositories\contacts\WriteContactInterface;
use App\Repositories\emails\WriteEmailInterface;
use App\Repositories\phoneNumbers\WritePhoneNumberInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ContactController extends Controller
{
    private ReadContactInterface $readContactInterface;
    private WriteContactInterface $writeContactInterface;
    private WriteAddressInterface $writeAddressInterface;
    private WriteEmailInterface $writeEmailInterface;
    private WritePhoneNumberInterface $writePhoneNumberInterface;

    public function __construct(
        ReadContactInterface $readContactInterface, 
        WriteContactInterface $writeContactInterface, 
        WriteAddressInterface $writeAddressInterface,
        WriteEmailInterface $writeEmailInterface,
        WritePhoneNumberInterface $writePhoneNumberInterface
     )
    {
        $this->readContactInterface = $readContactInterface;
        $this->writeContactInterface = $writeContactInterface;
        $this->writeAddressInterface = $writeAddressInterface;
        $this->writeEmailInterface = $writeEmailInterface;
        $this->writePhoneNumberInterface = $writePhoneNumberInterface;
    }

    /**
     * Get all contacts with addresses, emails, and phone numbers associated with
     *
     * @param Request $request
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/
     * @name contacts.index
     * 
     */
    public function index(Request $request)
    {
        try {
            $contacts = $this->readContactInterface->getAll();
            return ApiResponse::success(['contacts' => $contacts]);
        } catch (Exception | Error $e) {
            return ApiResponse::unprocessable(null, null, $e->getMessage());
        }
    }

    /**
     * Create a new contact in the database
     * @param UpsertContactRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method POST
     * @route /api/contacts/
     * @name contacts.store
     *
     */
    public function store(UpsertContactRequest $request)
    {
        try {
            $data = $request->validated();
            $contact = $this->writeContactInterface->store($data);
            $this->writePhoneNumberInterface->executeAction($data, $contact);
            $this->writeAddressInterface->executeAction($data, $contact);
            $this->writeEmailInterface->executeAction($data, $contact);
            return ApiResponse::created();
        } catch (InvalidArgumentException $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        } 
    }

    /**
     * Get a single contact from database
     *
     * @param Contact $contact
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/{contact}
     * @name contacts.show
     *
     */
    public function show(Contact $contact)
    {
        try {
            $contact = $this->readContactInterface->getById($contact);
            return ApiResponse::success(['contact' => $contact]);
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Update the specified contact in storage.
     * 
     * @param Contact $contact
     * @param UpsertContactRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method PUT
     * @route /api/contacts/{contact}
     * @name contacts.update
     *
     */
    public function update(Contact $contact, UpsertContactRequest $request)
    {
        try{
            $data = $request->validated();
            $contact = $this->writeContactInterface->update($contact, $data);
            $this->writePhoneNumberInterface->executeAction($data, $contact);
            $this->writeAddressInterface->executeAction($data, $contact);
            $this->writeEmailInterface->executeAction($data, $contact);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Delete a contact in the database
     *
     * @param Contact $contact
     * 
     * @return JsonResponse $response
     *
     * @method DELETE
     * @route /api/contacts/{contact}
     * @name contacts.destroy
     *
     */
    public function destroy(Contact $contact)
    {
        try {
            $this->writePhoneNumberInterface->destroy($contact);
            $this->writeAddressInterface->destroy($contact);
            $this->writeEmailInterface->destroy($contact);
            $this->writeContactInterface->delete($contact);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }
}
