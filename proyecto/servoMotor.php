
<?php
session_start();
$active_page = 'proyectos';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Aprendé a controlar un servomotor con Arduino paso a paso.">

    <title>Servomotor con Arduino - ARDUNOVA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20261020-5">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container section-container py-4">

    <h1 class="section-title">Servomotor con Arduino</h1>

    <p>
        En este proyecto vamos a aprender a controlar un servomotor
        utilizando Arduino. Un servomotor es un dispositivo que permite
        mover un eje hasta una posición determinada, por ejemplo,
        0°, 90° o 180°.
    </p>

    <h2>¿Qué vamos a aprender?</h2>

    <p>
        Vamos a conectar un servomotor a una placa Arduino y programarlo
        para que se mueva automáticamente entre diferentes ángulos.
        Es un proyecto útil para iniciarse en la robótica y la automatización.
    </p>

    <div class="text-center my-4">
        <img
            src="../assets/img/servomotor.jpg"
            alt="Servomotor utilizado en el proyecto"
            class="img-fluid rounded"
            style="max-width: 500px;"
        >
    </div>

    <h2>Lista de componentes</h2>

    <ul>
        <li>Una placa Arduino Uno.</li>
        <li>Un servomotor, por ejemplo, un SG90.</li>
        <li>Cables jumper.</li>
        <li>Cable USB para conectar Arduino a la computadora.</li>
    </ul>

    <h2>Conexión de los cables</h2>

    <p>Para un servomotor SG90, las conexiones habituales son:</p>

    <ul>
        <li><strong>Cable rojo:</strong> alimentación de 5 V.</li>
        <li><strong>Cable marrón o negro:</strong> GND.</li>
        <li><strong>Cable naranja o amarillo:</strong> señal digital 9.</li>
    </ul>

    <p>
        Los colores pueden variar según el modelo. Antes de conectar
        el componente, verificá las indicaciones de su fabricante.
        Si el servo consume más corriente de la que puede entregar
        la placa, utilizá una alimentación externa adecuada y conectá
        las masas en común.
    </p>

    <div class="text-center my-4">
        <img
            src="../assets/img/servomotor1.png"
            alt="Imagen complementaria del proyecto de servomotor"
            class="img-fluid rounded"
            style="max-width: 600px;"
        >
    </div>

    <h2>Procedimiento paso a paso</h2>

    <ol>
        <li>Conectá el cable de alimentación del servomotor a 5 V, si el modelo lo permite.</li>
        <li>Conectá el cable de tierra a GND.</li>
        <li>Conectá el cable de señal al pin digital 9.</li>
        <li>Abrí el IDE de Arduino en la computadora.</li>
        <li>Copiá el código que aparece a continuación.</li>
        <li>Seleccioná la placa y el puerto correctos y cargá el programa.</li>
        <li>Observá cómo cambia la posición del servomotor.</li>
    </ol>

    <h2>Código de Arduino</h2>

    <p>
        La biblioteca Servo permite controlar la posición del motor
        mediante la función <code>write()</code>.
    </p>

    <pre class="p-3 rounded" style="background-color: #f1f1f1; color: #222; white-space: pre-wrap;"><code>#include &lt;Servo.h&gt;

Servo miServo;

void setup() {
    miServo.attach(9);
}

void loop() {
    miServo.write(0);
    delay(1000);

    miServo.write(90);
    delay(1000);

    miServo.write(180);
    delay(1000);

    miServo.write(90);
    delay(1000);
}</code></pre>

    <h2>¿Cómo funciona el código?</h2>

    <ul>
        <li><code>#include &lt;Servo.h&gt;</code> incorpora la biblioteca para controlar el servomotor.</li>
        <li><code>Servo miServo;</code> crea el objeto que representa al motor.</li>
        <li><code>miServo.attach(9);</code> indica que la señal está conectada al pin 9.</li>
        <li><code>miServo.write(90);</code> solicita que el motor se coloque en el ángulo indicado.</li>
        <li><code>delay(1000);</code> espera un segundo antes de continuar.</li>
        <li><code>loop()</code> repite la secuencia continuamente.</li>
    </ul>

    <h2>Resultado esperado</h2>

    <p>
        Cuando el programa se ejecute, el servomotor intentará ubicarse
        en 0°, luego en 90°, después en 180° y volverá a 90°.
        Así podemos comprobar cómo Arduino controla su posición.
    </p>

    <div class="text-center button-container my-4">
        <a href="proyectos.php" class="btn btn-outline-cyan">
            ← Volver a Proyectos
        </a>
    </div>

</main>

<?php include __DIR__ . '/../includes/chatbot.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
