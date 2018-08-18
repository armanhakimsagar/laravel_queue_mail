STEPS :

* set .env file :

  Host:	smtp.mailtrap.io

  Port:	25 or 465 or 2525

  Username:	********

  Password:	********


* set route for mail send :


  use App\Mail\send_mail;

  Route::get('send_mail',function(){

    Mail::to('abc@gmail.com')->send(new send_mail());

  });



* make mail class for send mail :

  php artisan make:mail send_mail



* queue table migration :

    php artisan queue:table




* php artisan migrate

  or 
  
  CREATE TABLE jobs( id int not null AUTO_INCREMENT PRIMARY KEY, queue varchar(1000) not null, 
     payload text not null, attempts tinyint not null, reserved_at int not null, 
     available_at int not null, created_at int not null )


* create job for mail class :

  php artisan make:job send_mail_job


* now move mail to functionality in send_mail_job controller handle() part:

  Mail::to('abc@gmail.com')->send(new send_mail());
  

* set dispatch job in route for run jobs everytime hit route :

  
    Route::get('send_mail',function(){
	       dispatch(new  send_mail_job());
	       return "email ok";
    });


    
* now set time for queue mail dispatch delay by carbon:

    Route::get('send_mail',function(){

	     $job = (new send_mailJob))
		            ->delay(Carbon::now()->addSecound(5));

              dispatch($job);

              return "email ok";

    });


* now active this delay by .env file :

  queue_driver : database (means listen dispatch delay)
  queue_driver : sync     (dont delay)



* now run this job by :

    php artisan queue:work



