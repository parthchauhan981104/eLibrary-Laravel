<?php
namespace App\Tasks;

use App\User;
use App\Books;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SendGrid\Mail\From;
use SendGrid\Mail\Mail;
use SendGrid\Mail\To;

class SendBooksCompleted
{
        public function __invoke()
        {

            $allusers = User::all();

            if ($allusers) {

                foreach ($allusers as $user) {

                  $mybooks_namesauth = array_slice(explode( ',' , str_replace("_", " ", $user->readbooks) ), -5);  //last 5 read books
                  $mybooks_names = array();
                  foreach ($mybooks_namesauth as $namea) {
                    $mybooksna = explode('-', $namea);
                    $i=0;
                    foreach ($mybooksna as $name) {
                      if($i % 2 != 0){
                        array_push($mybooks_names, $name);
                      }
                      $i++;
                    }
                  }
                  $mybooks = Books::whereIn('name', $mybooks_names)->get();

                  $this->sendEmail($user, $mybooks);

                }

            }

        }


        private function sendEmail($user, $mybooks) {

            $contents = array();

            foreach ($mybooks as $book){

                ?><?php ob_start();
                ?>
                    <li>
                      <h3><?php echo (ucwords($book->name)); ?></h3>
                      <p>
                        <?php echo ("By " . ucwords($book->author_name)); ?>
                      </p>
                      <br>
                    </li>

              <?php
              $content = ob_get_clean();
              array_push($contents, $content);

              ?>

          <?php
            }

            $textContent = "<p>Hi $user->name, We <b>miss you</b>,
               Here are your last 5 read books:
               $books ";
            $textContent = "Hi $name, We got $userCount new users today,
                a $percentageDiff difference from yesterday</p>";
            $from = new From(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
            $subject = "Here's how our app performed today.";
            $recipient = new To(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));

            $email = new Mail();
            $email->setFrom($from);
            $email->setSubject($subject);
            $email->addTo($recipient);
            $email->addContent("text/plain", $textContent);
            $email->addContent("text/html", $htmlContent);

            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
            try {
                $response = $sendgrid->send($email);
                $context = json_decode($response->body());
                if ($response->statusCode() == 202) {
                    Log::info("Metric email has been sent", ["context" => $context]);
                }else {
                    Log::error("Failed to send metric email", ["context" => $context]);
                }
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
}
