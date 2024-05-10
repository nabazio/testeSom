<?php
require_once 'vendor/autoload.php';

// Carregando e inicializando o parser de PDF
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('arquivos/relatorio.pdf');

// Extraindo o texto do PDF
$texto = $pdf->getText();

// Dividindo o texto em pedaços menores para evitar limitação da API de síntese de voz
$pedacos = explode("\n", wordwrap($texto, 1000, "\n", true));
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Acessível</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 16px;
            line-height: 1.6;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class="container mt-4">
    <h3 class="mb-4">Pressione 'Espaço' para narrar e 'M' para busca por voz</h3>
    <div class="embed-responsive embed-responsive-16by9 mb-4">
        <iframe class="embed-responsive-item" src="arquivos/relatorio.pdf"></iframe>
    </div>

    <script>
        var partesTexto = <?php echo json_encode($pedacos); ?>;
        var indiceAtual = 0;
        var narrando = false;

        // Função para iniciar o reconhecimento de voz
        function iniciarBuscaPorVoz() {
            if (narrando) {
                window.speechSynthesis.cancel(); // Pausa a narração atual
                narrando = false;
            }
            var recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'pt-BR';
            recognition.onresult = function(event) {
                var textoFalado = event.results[0][0].transcript;
                buscarElerTexto(textoFalado);
            };
            recognition.start();
        }

        function buscarElerTexto(textoFalado) {
            var encontrado = false;
            for (var i = 0; i < partesTexto.length; i++) {
                if (partesTexto[i].includes(textoFalado)) {
                    falarTexto(partesTexto[i]);
                    encontrado = true;
                    break;
                }
            }
            if (!encontrado) {
                falarTexto('Conteúdo não encontrado.');
            }
        }

        function falarTexto(texto) {
            var msg = new SpeechSynthesisUtterance(texto);
            msg.lang = 'pt-BR';
            msg.onend = function() {
                if (indiceAtual < partesTexto.length && narrando) {
                    continuarNarracao();
                } else {
                    indiceAtual = 0;
                    narrando = false;
                }
            };
            window.speechSynthesis.speak(msg);
        }

        function continuarNarracao() {
            if (!narrando) {
                indiceAtual = 0; // Reinicia a narrativa
            } else if (indiceAtual < partesTexto.length) {
                falarTexto(partesTexto[indiceAtual++]);
            } else {
                indiceAtual = 0; // Reinicia a narrativa
                narrando = false;
            }
        }

        document.body.onkeyup = function(e) {
            if (e.code === "Space") {
                e.preventDefault();
                if (!narrando) {
                    narrando = true;
                    continuarNarracao();
                } else {
                    window.speechSynthesis.cancel();
                    narrando = false;
                }
            } else if (e.code === "KeyM") {
                e.preventDefault();
                iniciarBuscaPorVoz();
            }
        }
    </script>
</body>

</html>