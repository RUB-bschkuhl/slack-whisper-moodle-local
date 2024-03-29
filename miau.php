<?php
require_once(__DIR__ . '/../../config.php');

$PAGE->set_url(new moodle_url('/local/miau_test/miau.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('MIau.nrw');
echo $OUTPUT->header();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to Feedback - Jokersession</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: #294466;
            background-color: #f4f4f4;
            padding: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #294466;
        }

        h2 {
            margin-bottom: 1rem;
            color: #294466;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
        }

        textarea {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            height: 150px;
            margin-bottom: 1rem;
        }

        .butts {
            background-color: #294466;
            color: #fff;
            border: none;
            padding: 2rem;
            border-radius: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .butts:hover {
            background-color: #273355;
        }

        .spinner-border {
            display: none;
            margin-left: 1rem;
        }

        .row {
            display: flex;
            justify-content: center;
        }

        .coach-card {
            margin: 1rem;
            padding: 1rem;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .mt-5 {
            margin-top: 5rem;
        }

        .text-center {
            text-align: center;
        }

        .mb-5 {
            margin-bottom: 5rem;
        }

        .mt-3 {
            margin-top: 3rem;
        }

        .text-light {
            color: #fff;
        }

        #transcriptContent,
        #suggestionsContent,
        #transcriptContentMan {
            border: 1px solid #ccc;
            padding: 1rem;
            border-radius: 4px;
            background-color: #f8f8f8;
            margin-bottom: 1rem;
        }

        #suggestion {
            font-weight: bold;
        }
    </style>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script> -->
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-3">Speech to Feedback - Jokersession</h1>
        <div class="coach-card">
            <div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <details open>
                            <summary><label for="prompt" class="form-label">Prompt:</label></summary>
                            <textarea id="prompt" rows="10" cols="50"></textarea>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Prompt select
                                </button>
                                <div class="dropdown-menu" id="promptMenu" aria-labelledby="dropdownMenuButton">
                                </div>
                            </div>
                        </details>
                        <div class>
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <button id="recordButton" class="butts m-2">Start Recording</button>
                                    <button id="suggestionButton" class="butts m-2">Get Suggestion</button>
                                    <button id="suggestionButtonGPT4" class="butts m-2">Get Suggestion GPT4</button>
                                    <button id="suggestionButtonLocal" class="butts m-2">Get Suggestion Local</button>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="coach-card">
                        <div>
                            <h2>Transkript</h2>
                            <div id="transcriptContent" style="min-height: 10em;"></div>
                            <textarea id="transcriptContentMan" rows="10" cols="50"></textarea>
                            <button id="transcriptSetButton" class="butts m-2">Set
                                Transcript</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="coach-card">
                        <div>
                            <h2>Vorschläge</h2>
                            <div id="suggestionsContent" style="min-height: em;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const recordButton = document.getElementById('recordButton');
            const transcriptDiv = document.getElementById('transcriptContent');
            const transcriptSetButton = document.getElementById('transcriptSetButton');

            const transcriptDivMan = document.getElementById('transcriptContentMan');
            const suggestionsDiv = document.getElementById('suggestionsContent');
            const suggestionButton = document.getElementById('suggestionButton');
            const suggestionButtonGPT4 = document.getElementById('suggestionButtonGPT4');
            const suggestionButtonLocal = document.getElementById('suggestionButtonLocal');
            let suggestionSelection = document.getElementById('promptMenu');
            const promptArea = document.getElementById('prompt');
            const transcriptInput = document.getElementById('transcriptContentMan');

            const suggestionStringArray = [
                {
                    val: `# IDENTITY and PURPOSE

You are an expert content summarizer. You take content in and output a Markdown formatted summary using the format below.

Take a deep breath and think step by step about how to best accomplish this goal using the following steps.

# OUTPUT SECTIONS

- Combine all of your understanding of the content into a single, 20-word sentence in a section called ONE SENTENCE SUMMARY:.

- Output the 10 most important points of the content as a list with no more than 15 words per point into a section called MAIN POINTS:.

- Output a list of the 5 best takeaways from the content in a section called TAKEAWAYS:.

# OUTPUT INSTRUCTIONS

- Create the output using the formatting above.
- You only output human readable Markdown.
- Output numbered lists, not bullets.
- Do not output warnings or notes—just the requested sections.
- Do not repeat items in the output sections.
- Do not start items with the same opening words.

# INPUT:

INPUT:`,
                    name: "Zusammenfassung",
                    key: 1
                },
                {
                    val: `# IDENTITY and PURPOSE
Create a Socratic dialogue based on the discussion. A Socratic dialogue is a method where, through questioning by a teacher, the learner is led to actively engage with the content and gain new insights.

Pose only the questions without providing any answers.
Answer should be in German.

##Example Sokratischer Dialog

Lehrer: Angenommen, wir betrachten das Konzept der Freiheit. Was verstehst du persönlich unter Freiheit?

Lehrer: Kannst du ein Beispiel aus deinem Alltag nennen, bei dem du dich besonders frei fühlst?

Lehrer: Gibt es Unterschiede zwischen persönlicher Freiheit und gesellschaftlicher Freiheit? Wie würdest du diese Unterschiede beschreiben?

Lehrer: Denkst du, dass absolute Freiheit möglich ist? Warum oder warum nicht?

Lehrer: Wie beeinflusst die Freiheit eines Einzelnen die Freiheit einer anderen Person? Kannst du ein Beispiel geben, in dem die Freiheit der einen Person die Freiheit einer anderen Person einschränkt?

Lehrer: Welche Rolle spielen Regeln und Gesetze in Bezug auf Freiheit? Fördern oder beschränken sie die Freiheit? Bitte erkläre deine Sichtweise mit einem Beispiel.

Lehrer: Wie wichtig ist es, Verantwortung für die eigene Freiheit zu übernehmen? Kannst du ein Szenario beschreiben, in dem jemand Verantwortung für seine Freiheit übernimmt oder vernachlässigt?

Lehrer: Gibt es einen Zusammenhang zwischen Freiheit und Glück? Inwiefern kann Freiheit zu einem glücklichen Leben beitragen?

Lehrer: Betrachten wir den Einfluss von Technologie auf unsere Freiheit. Siehst du Technologie eher als ein Werkzeug zur Erweiterung oder als eine Bedrohung für unsere Freiheit? Bitte begründe deine Meinung.

Lehrer: Abschließend, wie können wir unsere Freiheit bewahren und gleichzeitig eine gerechte und funktionierende Gesellschaft aufrechterhalten? Welche Maßnahmen wären deiner Meinung nach notwendig?

Input:
`,
        name: "Sokratischer Dialog",
        key: 2
                },
                {
                    val: "",
                    name: "Leer",
                    key: 3
                }
            ];

            let isRecording = false;
            let mediaRecorder;
            let intervalId;
            let full_transcript = '';

        suggestionButton.addEventListener('click', async () => {
            const promptText = document.getElementById('prompt').value;
            //#URL ANPASSEN
            const response = await fetch('http://127.0.0.1:8083/generate-suggestionsgpt3', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ transcript: full_transcript, prompt: promptText })
            });

            const data = await response.json();
            console.log(data);
            suggestionsDiv.innerText = data.suggestions;
        });

        suggestionButtonGPT4.addEventListener('click', async () => {
            const promptText = document.getElementById('prompt').value;
            //#URL ANPASSEN
            const response = await fetch('http://127.0.0.1:8083/generate-suggestionsgpt4', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ transcript: full_transcript, prompt: promptText })
            });

                const data = await response.json();
                console.log(data);
                suggestionsDiv.innerText = data.suggestions;
            });

            recordButton.addEventListener('click', () => {
                console.log("test")
                if (!isRecording) {
                    startRecording();
                    recordButton.textContent = 'Stop Recording';
                } else {
                    stopRecording();
                    recordButton.textContent = 'Start Recording';
                }
                isRecording = !isRecording;
            });

            transcriptSetButton.addEventListener('click', () => {
                full_transcript = transcriptInput.value;
                transcriptDiv.innerText = full_transcript; 
            });

            suggestionButtonLocal.addEventListener('click', async () => {
            const promptText = document.getElementById('prompt').value;
            //#URL ANPASSEN
            const response = await fetch('http://127.0.0.1:8083/generate_suggestions_local', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ transcript: full_transcript, prompt: promptText })
            });

                const data = await response.json();
                console.log(data);
                suggestionsDiv.innerText = data.suggestions;
            });

            async function startRecording() {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

                function createRecorder() {
                    mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.addEventListener('dataavailable', async event => {
                        console.log('Data available');
                        const audioBlob = event.data;
                        const formData = new FormData();
                        formData.append('audio', audioBlob);
                        //#URL ANPASSEN
                        const response = await fetch('http://127.0.0.1:8083/process-audio', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await response.json();
                        if (data.transcript != null) {
                            full_transcript += data.transcript;
                            transcriptDiv.innerText = full_transcript;
                        }
                        console.log(data.transcript)
                    });

                    mediaRecorder.start();
                }

                createRecorder(); // Start recording initially

                // Set interval to stop current recorder and start a new one every 10 seconds
                intervalId = setInterval(() => {
                    mediaRecorder.stop();
                    createRecorder();
                }, 5000);
            }

            function stopRecording() {
                clearInterval(intervalId); // Stop the interval
                mediaRecorder.stop();
            }

            document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('dropdownMenuButton');
    const dropdownMenu = document.getElementById('promptMenu');

    function toggleDropdown() {
        dropdownMenu.classList.toggle('show');
    }

    dropdown.addEventListener('click', toggleDropdown);

    // Funktion, um Dropdown-Elemente hinzuzufügen
    function appendPrompts() {
        suggestionStringArray.forEach(suggestion => {
            let a = document.createElement('button'); // Ändere dies zu 'button', um semantisch korrekt zu sein
            a.textContent = suggestion.name;
            a.classList.add('dropdown-item');
            a.setAttribute('type', 'button');
            a.addEventListener('click', function () {
                promptArea.value = suggestion.val; // Verwende value statt innerText für textarea
                dropdownMenu.classList.remove('show'); // Schließe das Dropdown nach der Auswahl
            });
            dropdownMenu.appendChild(a);
        });
    }

    appendPrompts();
});

        </script>
</body>
</html>

<?php

echo $OUTPUT->footer();
