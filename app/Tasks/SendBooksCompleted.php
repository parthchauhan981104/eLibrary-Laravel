<?php
namespace App\Tasks;

use App\User;
use App\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SendGrid\Mail\From;
use SendGrid\Mail\Mail;
use SendGrid\Mail\To;

class SendBooksCompleted
{
    public function __invoke()
    {
        $allUsers = User::all();

        if ($allUsers) {
            foreach ($allUsers as $user) {
                $myBooks = $user->books;

                $this->sendEmail($user, $myBooks);
            }
        }
    }


    private function sendEmail($user, $myBooks)
    {
        $contents = array();

        foreach ($myBooks as $book) {
            ?><?php ob_start(); ?>
                <li>
                  <h3><?php echo(ucwords($book->name)); ?></h3>
                  <p>
                    <?php echo("By " . ucwords($book->author->name)); ?>
                  </p>
                  <br>
                </li>

          <?php
          $content = ob_get_clean();
            array_push($contents, $content); ?>

      <?php
        }

        $textContent = "<p>Hi " . ucwords($user->name) . ", We <b>miss you</b>,
           Here are your last 5 read books:" . $contents;
        $textContent = "Hi " . ucwords($user->name) . ", We miss you,
           Here are your last 5 read books:" . $myBooks;
        $from = new From(Config::get('notification.details.adminEmail'), Config::get('notification.details.adminName'));
        $subject = "eLibrary Notifications";
        $recipient = new To(Config::get('notification.details.adminEmail'), Config::get('notification.details.adminName'));

        $email = new Mail();
        $email->setFrom($from);
        $email->setSubject($subject);
        $email->addTo($recipient);
        $email->addContent("text/plain", $textContent);
        $email->addContent("text/html", $htmlContent);

        $sendgrid = new \SendGrid(Config::get('notification.details.sendgridApiKey'));
        try {
            $response = $sendgrid->send($email);
            $context = json_decode($response->body());
            if ($response->statusCode() == 202) {
                Log::info("Metric email has been sent", ["context" => $context]);
            } else {
                Log::error("Failed to send metric email", ["context" => $context]);
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
