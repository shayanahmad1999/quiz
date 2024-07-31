<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionNumber = $_POST['questionNumber'];
    $answer = $_POST['answer'];
    $_SESSION['answers'][$questionNumber] = $answer;

    if ($questionNumber == count($questions)) {
        showResult();
        exit();
    } else {
        $nextQuestion = $questionNumber + 1;
        showQuestion($nextQuestion, $questions, $options);
        exit();
    }
}

function showResult() {
    $answers = $_SESSION['answers'];
    $resultCount = array_count_values($answers);
    $maxOption = array_search(max($resultCount), $resultCount);

    $descriptions = [
        'a' => 'You may excel in careers that involve creativity, self-expression, and independence, such as arts, writing, or design.',
        'b' => 'You might thrive in fields that require analytical thinking, problem-solving, and intellectual challenges, like science, technology, engineering, or finance.',
        'c' => 'Consider careers that focus on helping others, making a social impact, and working in collaborative environments, such as healthcare, social work, or education.',
        'd' => 'You could be well-suited for careers that involve physical activity, health, and wellness, such as sports, fitness, or outdoor recreation.'
    ];

    echo "<h1>Quiz Result</h1>";
    echo "<p>Your most selected option is: <strong>" . strtoupper($maxOption) . "</strong></p>";
    echo "<p>" . $descriptions[$maxOption] . "</p>";
    session_destroy();
}

function showQuestion($questionNumber, $questions, $options) {
    $question = $questions[$questionNumber];
    $choices = $options[$questionNumber];
    ?>
    <h1>Question <?= $questionNumber ?></h1>
    <form>
        <h2><?= $question ?></h2>
        <?php foreach ($choices as $key => $value) : ?>
            <div>
                <label>
                    <input type="radio" name="answer" value="<?= $key ?>" required> <?= $value ?>
                </label>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="questionNumber" value="<?= $questionNumber ?>">
        <button type="button" onclick="submitAnswer(<?= $questionNumber ?>)">Next</button>
    </form>
    <?php
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['q'])) {
    $questionNumber = (int)$_GET['q'];
    showQuestion($questionNumber, $questions, $options);
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function startQuiz() {
        $.ajax({
            url: '',
            type: 'GET',
            data: { q: 1 },
            success: function(response) {
                $('#quiz-container').html(response);
                $('#start-btn').hide();
                $('#title').hide();
            }
        });
    }

    function submitAnswer(questionNumber) {
        var answer = $('input[name="answer"]:checked').val();
        if (answer) {
            $.ajax({
                url: '',
                type: 'POST',
                data: { questionNumber: questionNumber, answer: answer },
                success: function(response) {
                    $('#quiz-container').html(response);
                }
            });
        } else {
            alert('Please select an answer.');
        }
    }
</script>

<div id="quiz-container">
    <h1 id="title">Welcome to the Career Preference Quiz</h1>
    <button id="start-btn" onclick="startQuiz()">Start Quiz</button>
</div>
