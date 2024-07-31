<style type="text/css">
    .all_question,
    #result,
    .temp_error {
        display: none;
    }
</style>
<?php

$questions = [
    1 => "What activities do you enjoy in your free time?",
    2 => "What subjects did you excel in during school?",
    3 => "What type of work environment do you prefer?",
    4 => "What motivates you the most?",
    5 => "Which statement best describes your communication style?",
    6 => "What are your long-term business goals?",
    7 => "How do you handle stress or pressure?",
    8 => "Which of these values is most important to you in a business?",
    9 => "What type of learning environment do you prefer?",
    10 => "Which business aspect are you most interested in?"
];

$options = [
    1 => ['a' => 'Reading, writing, or creating art', 'b' => 'Solving puzzles or working with numbers', 'c' => 'Helping others or volunteering', 'd' => 'Playing sports or being physically active'],
    2 => ['a' => 'English, literature, or history', 'b' => 'Math, science, or computer programming', 'c' => 'Social studies, psychology, or sociology', 'd' => 'Physical education, sports, or outdoor activities'],
    3 => ['a' => 'Quiet and solitary', 'b' => 'Structured and organized', 'c' => 'Collaborative and social', 'd' => 'Dynamic and active'],
    4 => ['a' => 'Expressing creativity and individuality', 'b' => 'Analyzing data and solving problems', 'c' => 'Making a positive impact on others\' lives', 'd' => 'Achieving personal fitness or competitive goals'],
    5 => ['a' => 'I enjoy expressing myself through writing or art.', 'b' => 'I prefer communicating logically and precisely.', 'c' => 'I excel at listening and providing support to others.', 'd' => 'I\'m good at conveying ideas through action or demonstration.'],
    6 => ['a' => 'To pursue a business that allows for self-expression and creativity.', 'b' => 'To work in a field that offers intellectual challenges and problem-solving opportunities.', 'c' => 'To make a difference in people\'s lives and contribute to social change.', 'd' => 'To have a business that involves physical activity and a healthy lifestyle.'],
    7 => ['a' => 'I find solace in creative outlets or personal hobbies.', 'b' => 'I analyze the situation and develop a strategic plan to address it.', 'c' => 'I seek support from friends, family, or mentors.', 'd' => 'I engage in physical exercise or outdoor activities to relieve stress.'],
    8 => ['a' => 'Freedom and independence', 'b' => 'Intellectual stimulation and growth', 'c' => 'Compassion and empathy', 'd' => 'Health and wellness'],
    9 => ['a' => 'Individual study or self-paced learning', 'b' => 'Classroom lectures and structured curriculum', 'c' => 'Group discussions and interactive workshops', 'd' => 'Hands-on experience and real-world applications'],
    10 => ['a' => 'Creativity and innovation', 'b' => 'Analytical thinking and problem-solving', 'c' => 'Helping others and making a difference', 'd' => 'Physical activity and movement']
];

$total_questions = count($questions);
foreach ($questions as $k => $question) {
    $text = '<div class="all_question question' . $k . '">';
    $text .= '<p>Question:' . $k . '/' . $total_questions . ') ' . $question . '</p>';
    foreach ($options[$k] as $ok => $ov) {
        $text .= '<p><label><input type="radio" name="question' . $k . '" value="' . $ok . '" />' . $ov . '</label></p>';
    }

    $text .= '<div class="temp_error">Please select an option</div>';

    $next = $k + 1;
    if ($k == $total_questions)
    $text .= '<button onclick="show_question(\'result\', \'' . $k . '\')">Submit</button>';
    else
    $text .= '<button onclick="show_question(\'' . $next . '\', \'' . $k . '\')">Next</button>';

    $text .= '</div>';
    echo $text;
}
?>
<div id="quiz-container">
    <h1 id="title">Welcome to the Career Preference Quiz</h1>
    <button id="start-btn" onclick="show_question('1',0)">Start Quiz</button>
</div>

<div id="result">

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function show_question(num, k) {
        if (k >= 1 && num !== 'result') {
            var checked = $('.question' + k + ' input[type="radio"]:checked');
            if (checked.length === 0) {
                $('.question' + k + ' .temp_error').show();
                return false;
            } else {
                $('.temp_error').hide();
            }
        }

        $('.all_question, #quiz-container').hide();
        if (num === 'result') {
            var countA = 0,
                countB = 0,
                countC = 0,
                countD = 0;
            $('input[type="radio"]').each(function(index, element) {
                if ($(this).is(':checked')) {

                    var value = $(this).val();

                    switch (value) {
                        case 'a':
                            countA++;
                            break;
                        case 'b':
                            countB++;
                            break;
                        case 'c':
                            countC++;
                            break;
                        case 'd':
                            countD++;
                            break;
                        default:
                            break;
                    }

                }
            });



            var maxCount = Math.max(countA, countB, countC, countD);
            var mostChecked = '';
            if (maxCount === countA) {
                mostChecked = 'Your interests lean towards creative fields such as writing, art, design, or performing arts. Consider businesss in advertising, graphic design, journalism, or entertainment';
            } else if (maxCount === countB) {
                mostChecked = 'You have strong analytical and problem-solving skills suited for businesss in STEM fields like engineering, computer science, finance, or research.';
            } else if (maxCount === countC) {
                mostChecked = 'Your desire to make a positive impact suggests businesss in healthcare, social work, counseling, teaching, or non-profit organizations could be fulfilling for you.';
            } else if (maxCount === countD) {
                mostChecked = 'Your preference for physical activity and hands-on experiences may align with businesss in sports coaching, fitness training, outdoor recreation, or physical therapy.';
            }


            $('#result').html('<p class="result_text">'+mostChecked+'</p><p class="result_notes">Remember, this quiz is just a starting point. Explore your interests further through internships, job shadowing, or informational interviews to find the best fit for your business path. Good luck!</p>');
            $('#result').show();
        } else {
            $('.question' + num).show();
        }
    }
</script>