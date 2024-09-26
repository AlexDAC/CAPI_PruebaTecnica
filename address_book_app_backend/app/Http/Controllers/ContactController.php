<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Contact;
use App\Repositories\contacts\ReadContactInterface;
use Error;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private ReadContactInterface $readContactInterface;

    public function __construct(ReadContactInterface $readContactInterface)
    {
        $this->readContactInterface = $readContactInterface;
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
     *
     * @return JsonResponse $response
     *
     * @method POST
     * @route /api/contacts/
     * @name contacts.store
     *
     */
    public function store()
    {

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
     * @return JsonResponse $response
     *
     * @method PUT
     * @route /api/contacts/{contact}
     * @name contacts.update
     *
     */
    public function update()
    {

    }

    /**
     * Delete a contact in the database
     *
     * @return JsonResponse $response
     *
     * @method DELETE
     * @route /api/contacts/{contact}
     * @name contacts.destroy
     *
     */
    public function destroy()
    {
        
    }
}
