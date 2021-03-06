<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Models\Accounts;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\Exception\NoSuchElementException;

class AccountsApiController extends Controller
{
    public function index()
    {
        $accounts = Accounts::all();

        return $accounts;
    }

    public function store(Request $request)
    {   
        

        $accountCount = $request->accountCount;
        if($accountCount > 0){
            $accounts_created = factory(Accounts::class)->make([
                'type' => 'linkedin'
            ]);
            
            $email = $accounts_created->email;
            $password = $accounts_created->password;
            $first_name = $accounts_created->first_name;
            $last_name = $accounts_created->last_name;
            $country = $accounts_created->country;
            $phonenumber = $accounts_created->phone_number;

            $serverUrl = 'http://localhost:4444';
            $desiredCapabilities = DesiredCapabilities::chrome();
            //$desiredCapabilities->setCapability('acceptSslCerts', false);
            
            //$desiredCapabilities->setCapability('chromeOptions', ['args' => ['-headless']]);
            $driver = RemoteWebDriver::create($serverUrl, $desiredCapabilities);
            $driver->get('https://www.linkedin.com/signup');
            sleep(15); // Wait to load the page (can be changed and its just and assemption)
    
            // Find search element by its id, write 'PHP' inside and submit
            $driver->findElement(WebDriverBy::id('email-address'))->sendKeys($email); 
            $driver->findElement(WebDriverBy::id('password'))->sendKeys($password); 
            $driver->findElement(WebDriverBy::id('join-form-submit'))->SendKeys(array(
                WebDriverKeys::ENTER
            ));
           
            $driver->findElement(WebDriverBy::id('first-name'))->sendKeys($first_name); 
            $driver->findElement(WebDriverBy::id('last-name'))->sendKeys($last_name); 
            $driver->findElement(WebDriverBy::id('join-form-submit'))->SendKeys(array(
                WebDriverKeys::ENTER
            )); 
    
            sleep(5);
            
            $innerUrlIframe = $driver->findElement(WebDriverBy::className('challenge-dialog__iframe'))->getAttribute('src');
            $driver->get($innerUrlIframe);
            $driver->findElement(WebDriverBy::id('select-register-phone-country'))->findElement(WebDriverBy::cssSelector("option[value='".$country."']"))->click();
            $driver->findElement(WebDriverBy::id('register-verification-phone-number'))->sendKeys($phonenumber); 
            $driver->findElement(WebDriverBy::id('register-phone-submit-button'))->SendKeys(array(
                WebDriverKeys::ENTER
            ));
            
            sleep(5); 
            //input__phone_verification_pin
            //register-phone-submit-button
            
    
            //typeahead-input-for-country
            //typeahead-input-for-city-district        
            // button data-control-name="continue"
    
            //typeahead-input-for-title
            //typeahead-input-for-employment-type-picker
            //typeahead-input-for-company
            // button data-control-name="continue"
    
            //email-confirmation-input
            // button data-control-name="verify"
    
            //data-control-name="skip"
            // Refresh the host page
    
            //$driver->takeScreenshot(__DIR__ . "/../../public/screenshots/screenshot.jpg");
    
        }
        
        
       
       
        /* $data['res'] = $serverUrl;
        $data['driver'] = $driver; */
         return response()->json([
            'message' => 'Account created successfuly.',
            'status' => 200,
        ], 200);
        //return Accounts::create($request->all());
    }

    public function update()
    {
        return false;
    }

    public function show(Accounts $account)
    {
        return $account;
    }

    public function destroy(Accounts $account)
    {
        return $account->delete();
    }


    private function generate_profiles($number, $username_length) {
        if (is_numeric($number) && $number != 0) {
            if ($number > 1000) { //put hard limit on generate request
                $number = 1000; 
            }
            $generated_emails = []; 
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
            $char_count = count($characters); 
            $tld = array("com"); 
            for ($i= 0; $i < $number; $i++){
                $randomName = ''; 
                for($j=0; $j<$username_length; $j++){
                    $randomName .= $characters[rand(0, strlen($characters) -1)];
                }
                $k = array_rand($tld); 
                $extension = $tld[$k]; 
                $email = $randomName . "@" ."looporigin".$extension; 

                $email = 'farhan@looporigin.com';
                $password = 'Hammad@11';
                $first_name = 'Farhan';
                $last_name = 'Shahid';
                $country = 'au';
                $phonenumber = '437541317';
                
                $generated_emails[] = $email; 	
            }
        }

        return $generated_emails;
    }
}
