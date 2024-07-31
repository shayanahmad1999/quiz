<style type="text/css">
    .all_question,
    #result,
    .temp_error,
    .email_field {
        display: none;
    }
</style>

<div id="quiz-container">
    <h1 id="title">U.S. Federal Grant Eligibility Assessment for Businesses</h1>
    <button id="start-btn" onclick="show_question('1', 0)">Start Quiz</button>
</div>

<div id="result"></div>

<form id="quiz-form" onsubmit="submitForm(); return false;" method="POST">
    <?php
    $questions = [
        1 => "Do you own the rights to your business idea, including any patents?",
        2 => "What stage is your product currently at?",
        3 => "Do you or someone on your team have the technical skills or experience to develop the product?",
        4 => "Which best describes your proposed technology?",
        5 => "How many people are employed by your business?",
        6 => "How much funding do you intend to apply for to cover product development costs over the next two years (excluding sales & marketing costs)?",
        7 => "Is your company majority-owned by U.S. citizens or permanent legal residents (>51%)",
        8 => "If you use subcontractors, will they be sourced from the U.S.?",
        9 => "What has been your average monthly revenue for the past 3 months?",
        10 => "What industry does your business operate in?",
    ];

    $options = [
        1 => ['a' => 'Yes, I own patents', 'b' => 'Yes, but I do not own any patents', 'c' => 'No, I sell someone else\'s product or service'],
        2 => ['a' => 'Idea or concept', 'b' => 'Development stage', 'c' => 'Tested with end users', 'd' => 'Pre-commercialization', 'e' => 'Already selling'],
        3 => ['a' => 'Yes', 'b' => 'No'],
        4 => ['a' => 'Developing a completely new technology', 'b' => 'Significantly improving on an existing technology', 'c' => 'Similar technology to an existing product on the market', 'd' => 'Not developing a technology'],
        5 => ['a' => '1', 'b' => '2-10', 'c' => '11-50', 'd' => '51-250', 'e' => '250+'],
        6 => ['a' => '$500k+', 'b' => '$250k to $499k', 'c' => '$250k to $499k', 'd' => '$50k to $99k', 'e' => '$10k to $49k', 'f' => '$1k to $9k', 'g' => 'I don\'t need funding for product development'],
        7 => ['a' => 'Yes', 'b' => 'Not currently, but we can set one up', 'c' => 'No'],
        8 => ['a' => 'Yes', 'b' => 'Yes, but only with funding', 'c' => 'No, I intend to outsource internationally', 'd' => 'I don\'t use subcontractors'],
        9 => ['a' => 'Pre-revenue', 'b' => '$1k to $10k', 'c' => '$10k to $20k', 'd' => '$20k to $50k', 'e' => '$50k to $100k', 'f' => '$100k to $250k', 'g' => '$250k+'],
        10 => ['comments'],
    ];

    $total_questions = count($questions);
    foreach ($questions as $k => $question) {
        $text = '<div class="all_question question' . $k . '">';
        $text .= '<p>Question:' . $k . '/' . $total_questions . ') ' . $question . '</p>';
        foreach ($options[$k] as $ok => $ov) {
            if ($ov == 'email') {
                $text .= '<p><label><input type="text" id="email' . $k . '" name="email' . $k . '" placeholder="Please Enter Email" /></label></p>';
            }
            if ($ov == 'comments') {
                $text .= '<p><label><input type="text" id="comment_question' . $k . '" name="comment_question' . $k . '" placeholder="Please specify" /></label></p>';
            } else {
                $text .= '<p><label><input type="radio" name="question' . $k . '" value="' . $ov . '" />' . $ov . '</label></p>';
            }
        }

        $text .= '<div class="temp_error">Please select an option*</div>';

        $next = $k + 1;
        if ($k == $total_questions)
            $text .= '<button type="button" onclick="show_email_field()">Submit</button>';
        else
            $text .= '<button type="button" onclick="show_question(\'' . $next . '\', \'' . $k . '\')">Next</button>';

        $text .= '</div>';
        echo $text;
    }
    ?>

    <div class="email_field">
        <p><label>Enter your email: <input type="text" id="user_email" name="user_email" /></label></p>
        <div class="email_error" style="display:none;">Please enter a valid email address.</div>
        <button type="button" onclick="submitForm()">Submit</button>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function show_question(num, k) {
        if (k >= 1 && num !== 'result') {
            var checked = $('.question' + k + ' input[type="radio"]:checked');
            var comment = $('#comment_question' + k).val();
            if (checked.length === 0 && comment.length === 0) {
                $('.question' + k + ' .temp_error').show();
                return false;
            } else {
                $('.question' + k + ' .temp_error').hide();
            }
        }

        $('.all_question, #quiz-container').hide();
        if (num === 'result') {

            $('#result').show();
        } else {
            $('.question' + num).show();
        }
    }

    function show_email_field() {
        var allAnswered = true;
        for (var i = 1; i <= <?= $total_questions ?>; i++) {
            var checked = $('input[name="question' + i + '"]:checked').length;
            var comment = $('#comment_question' + i).val();
            if (checked === 0 && !comment) {
                $('.question' + i + ' .temp_error').show();
                allAnswered = false;
            } else {
                $('.question' + i + ' .temp_error').hide();
            }
        }

        if (allAnswered) {
            $('.all_question').hide();
            $('.email_field').show();
        }
    }

    function submitForm() {
        var email = $('#user_email').val();
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            $('.email_error').show();
            return false;
        } else {
            $('.email_error').hide();
        }

        var formData = $('#quiz-form').serialize();

        $.ajax({
            url: 'send_email.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#result').html('<p>' + response.message + '</p>');
                } else {
                    $('#result').html('<p>' + response.message + '</p>');
                }
                $('#result').show();
                $('.email_field').hide();
            },
            error: function() {
                $('#result').html('<p>There was an error sending the email.</p>');
                $('#result').show();
                $('.email_field').hide();
            }
        });
    }
</script>