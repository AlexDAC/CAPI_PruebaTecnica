<?php

namespace App\Services\emails;

use App\Models\Contact;
use App\Models\Email;
use App\Repositories\emails\WriteEmailInterface;

class WriteEmailService implements WriteEmailInterface 
{   
    /**
     * execute and action depending of the type of status of the email, the actions can be:
     * create, update or delete
     *
     * @param array $data
     * @param Contact $contact
     * 
     * @return void
     */
    public function executeAction(array $data, Contact $contact): void
    {
        if(!isset($data['emails']) || empty($data['emails'])){
            return;
        }
        foreach($data['emails'] as $email){
            switch($email["status"]){
                case "new":
                    $this->store($contact, $email);
                break;
                case "update":
                    $this->update($email['id'], $email);
                    break;
                case "delete":
                    $this->delete($email['id']);
                    break;
            }
        }
    }

    /**
     * Create an contact in the database
     *
     * @param Contact $contact
     * @param array $email
     * 
     * @return void
     */
    private function store(Contact $contact, array $email): void
    {
        $contact->emails()->create(["email" => $email['email']]);
    }

    /**
     * Update data of a address in the database
     *
     * @param int $emailId
     * @param array $data
     * 
     * @return void
     */
    private function update(int $emailId, array $data): void
    {
        $email = Email::find($emailId);
        $email->update([
            "email" => $data['email']
        ]);
    }

    
    /**
     * Delete a single address from the database
     *
     * @param Email $email
     * 
     * @return void
     */
    private function delete(Email $email): void
    {
        $email->delete();
    }

    /**
     * Delete all the emails related to Contact from the database
     *
     * @param Contact $contact
     * 
     * @return void
     */
    public function destroy(Contact $contact): void
    {
        $contact->emails()->delete();
    }
}
