<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL);
    if (!$user_email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    $total_questions = 0;
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question') === 0) {
            $total_questions++;
        }
    }

    $subject = "Quiz Results";

    $message = '
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    background-color: #f4f4f4;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #333;
                    text-align: center;
                }
                ul {
                    list-style-type: none;
                    padding: 0;
                }
                li {
                    margin-bottom: 10px;
                }
                .footer {
                    margin-top: 20px;
                    text-align: center;
                    color: #666;
                }
            </style>
        <body>
            <div class="container">
                <h1>Quiz Results</h1>
                <ul>';

    for ($i = 1; $i <= $total_questions; $i++) {
        $answer_key = "question$i";
        $answer = isset($_POST[$answer_key]) ? htmlspecialchars($_POST[$answer_key]) : '';

        $message .= "<li><strong>Answer $i:</strong> " . $answer . "</li>";
    }

    $message .= '
                </ul>
            </div>
            <div class="footer">
                <p>User Email ' . $user_email . '</p>
            </div>
        </body>
    ';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: no-reply@example.com' . "\r\n";

    if (mail("shayanahmad235@gmail.com", $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
