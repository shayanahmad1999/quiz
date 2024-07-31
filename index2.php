<style type="text/css">
    .all_question,
    #result,
    .temp_error {
        display: none;
    }
</style>
<?php

$questions = [
    1 => "What stage are you at in your entrepreneurial journey?",
    2 => "Which area do you feel least confident in?",
    3 => "What aspect of starting or growing a business keeps you up at night?",
    4 => "Which of the following areas do you believe would have the most significant impact on your business's success if improved?",
    5 => "What is your primary goal as an entrepreneur right now?",
];

$options = [
    1 => [
        'a' => 'Exploring business ideas and determining the type of business to start',
        'b' => 'Building a team and forming partnerships',
        'c' => 'Creating internal systems and processes for business operations',
        'd' => 'Establishing and nurturing customer relationships',
        'e' => 'Conducting customer discovery and market research',
        'f' => 'Raising capital and securing funding for your business'
    ],
    2 => [
        'a' => 'Identifying a viable business idea',
        'b' => 'Finding and recruiting suitable team members',
        'c' => 'Developing efficient internal systems and workflows',
        'd' => 'Cultivating strong relationships with customers',
        'e' => 'Conducting effective market research and customer interviews',
        'f' => 'Accessing funding and navigating the fundraising process'
    ],
    3 => [
        'a' => 'Unsure about the direction or niche for my business',
        'b' => 'Worried about finding the right people to join my team',
        'c' => 'Concerned about operational inefficiencies and lack of structure',
        'd' => 'Frustrated with acquiring and retaining customers',
        'e' => 'Anxious about validating my business idea and market demand',
        'f' => 'Stressed about the financial aspects and funding my business'
    ],
    4 => [
        'a' => 'Idea generation and business concept clarity',
        'b' => 'Team building and talent acquisition',
        'c' => 'Operational efficiency and system optimization',
        'd' => 'Customer acquisition and retention strategies',
        'e' => 'Market research and understanding customer needs',
        'f' => 'Financial management and securing investment'
    ],
    5 => [
        'a' => 'To develop a unique and viable business idea',
        'b' => 'To build a strong and cohesive team',
        'c' => 'To streamline and optimize business processes',
        'd' => 'To grow and retain a loyal customer base',
        'e' => 'To validate my business concept and target market',
        'f' => 'To secure funding to scale and expand my business'
    ],
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
                countE = 0;
                countF = 0;
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
                        case 'e':
                        countE++;
                        break;
                        case 'f':
                        countF++;
                        break;
                        default:
                            break;
                    }

                }
            });



            var maxCount = Math.max(countA, countB, countC, countD, countE, countF);
            var mostChecked = '';
            if (maxCount === countA) {
                mostChecked = 'You may need assistance in figuring out the type of business to start and refining your business idea.';
            } else if (maxCount === countB) {
                mostChecked = 'You may need support in building a team and forming strategic partnerships';
            } else if (maxCount === countC) {
                mostChecked = 'You may require help in creating internal systems and processes to improve operational efficiency.';
            } else if (maxCount === countD) {
                mostChecked = 'You may benefit from guidance in creating and nurturing customer relationships.';
            }else if (maxCount === countE) {
                mostChecked = 'You may need assistance with customer discovery, market research, and understanding customer needs.';
            }else if (maxCount === countF) {
                mostChecked = 'You may need support in raising capital and navigating the fundraising process.';
            }


            $('#result').html('<p class="result_text">'+mostChecked+'</p><p class="result_notes">Identifying your areas of need is the first step toward obtaining the right support to achieve your entrepreneurial goals. Consider seeking mentorship, joining entrepreneurial networks, or enrolling in relevant courses or workshops to address these needs effectively.</p>');
            $('#result').show();
        } else {
            $('.question' + num).show();
        }
    }
</script>