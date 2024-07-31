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

    $subject = "Your Quiz Results";

    $message = "<html><body>";
    $message .= "<h1>Your Quiz Results:</h1><ul>";
    for ($i = 1; $i <= $total_questions; $i++) {
        $answer_key = "question$i";
        $answer = isset($_POST[$answer_key]) ? htmlspecialchars($_POST[$answer_key]) : '';

        $comment_key = "comment_question$i";
        $comment = isset($_POST[$comment_key]) ? htmlspecialchars($_POST[$comment_key]) : '';

        $message .= "<li><strong>Answer $i:</strong> " . ($comment ?: $answer) . "</li>";
    }

    $message .= "</ul>";
    $message .= "<p>Thank you for completing the assessment. Based on your responses, we can determine your eligibility for U.S. federal grant funding.</p>";
    $message .= "</body></html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: no-reply@example.com' . "\r\n";

    if (mail($user_email, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
