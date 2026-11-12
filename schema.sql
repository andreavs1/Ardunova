-- Base de datos de ARDUNOVA
CREATE DATABASE IF NOT EXISTS ardunova CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ardunova;

-- Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuarios INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tutoriales (para poder referenciarlos desde la tabla de progreso)
CREATE TABLE IF NOT EXISTS tutoriales (
    id_tutorial INT AUTO_INCREMENT PRIMARY KEY,
    categoria_t VARCHAR(20) NOT NULL
);

-- Tabla intermedia: tutorial completado por cada usuario
-- completado: 1 = completado, 0 = no completado
CREATE TABLE IF NOT EXISTS progreso (
    id_progreso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuarios INT NOT NULL,
    id_tutorial INT NOT NULL,
    completado BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_usuarios) REFERENCES usuarios(id_usuarios)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_tutorial) REFERENCES tutoriales(id_tutorial)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE (id_usuarios, id_tutorial),
    CHECK (completado IN (0, 1))
);

-- Categorías de los tutoriales
INSERT INTO tutoriales (id_tutorial, categoria_t) VALUES
    (1, 'Principiante'), (2, 'Principiante'), (3, 'Principiante'), (4, 'Principiante'),
    (5, 'Principiante'), (6, 'Principiante'), (7, 'Principiante'), (8, 'Principiante'),
    (9, 'Intermedio'), (10, 'Intermedio'), (11, 'Intermedio'), (12, 'Intermedio'),
    (13, 'Intermedio'), (14, 'Intermedio'), (15, 'Intermedio'), (16, 'Intermedio'),
    (17, 'Avanzado'), (18, 'Avanzado'), (19, 'Avanzado'), (20, 'Avanzado'),
    (21, 'Avanzado'), (22, 'Avanzado'), (23, 'Avanzado'), (24, 'Avanzado');



--Agregamos las columnas correspondientes a la tabla progreso.
 ALTER TABLE progreso
     MODIFY COLUMN id_tutorial INT NULL;

 ALTER TABLE progreso
     MODIFY COLUMN id_tutorial INT NULL;

ALTER TABLE progreso
    ADD COLUMN id_proyecto INT NULL;

ALTER TABLE progreso
     ADD CONSTRAINT unique_usuario_proyecto UNIQUE (id_usuarios, id_proyecto);

ALTER TABLE progreso
    ADD CONSTRAINT fk_progreso_proyecto 
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto)
    ON DELETE CASCADE ON UPDATE CASCADE;


 -- 1. Modificación de la tabla tutoriales agregando las columnas para Wokwi
ALTER TABLE tutoriales 
    ADD COLUMN badge VARCHAR(50) NOT NULL AFTER id_tutorial,
    ADD COLUMN titulo VARCHAR(150) NOT NULL AFTER badge,
    ADD COLUMN subtitulo TEXT AFTER titulo,
    ADD COLUMN concepto_titulo VARCHAR(150) AFTER subtitulo,
    ADD COLUMN concepto_descripcion TEXT AFTER concepto_titulo,
    ADD COLUMN codigo_titulo VARCHAR(100) AFTER concepto_descripcion,
    ADD COLUMN codigo_lenguaje VARCHAR(50) AFTER codigo_titulo,
    ADD COLUMN codigo_fuente TEXT AFTER codigo_lenguaje,
    ADD COLUMN wokwi_project_id VARCHAR(50) DEFAULT NULL AFTER codigo_fuente,
    ADD COLUMN wokwi_titulo VARCHAR(255) DEFAULT NULL AFTER wokwi_project_id,
    ADD COLUMN wokwi_instruccion TEXT DEFAULT NULL AFTER wokwi_titulo,
    ADD COLUMN wokwi_nota TEXT DEFAULT NULL AFTER wokwi_instruccion,
    ADD COLUMN quiz_pregunta TEXT AFTER wokwi_nota,
    ADD COLUMN quiz_mensaje_correcto TEXT AFTER quiz_pregunta,
    ADD COLUMN quiz_mensaje_incorrecto TEXT AFTER quiz_mensaje_correcto;

-- 2. Creación de tablas relacionadas
CREATE TABLE IF NOT EXISTS tutorial_funciones (
    id_funcion INT AUTO_INCREMENT PRIMARY KEY,
    id_tutorial INT NOT NULL,
    icono VARCHAR(10),
    titulo VARCHAR(100),
    descripcion TEXT,
    detalle TEXT,
    FOREIGN KEY (id_tutorial) REFERENCES tutoriales(id_tutorial)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS tutorial_quiz_opciones (
    id_opcion INT AUTO_INCREMENT PRIMARY KEY,
    id_tutorial INT NOT NULL,
    texto_opcion TEXT NOT NULL,
    es_correcta BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_tutorial) REFERENCES tutoriales(id_tutorial)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- 3. Actualización de Tutoriales (Del 1 al 9 con soporte Wokwi opcional por si querés rellenar el project_id)

UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 1', titulo='¿Qué es Arduino?', subtitulo='Conocé qué es Arduino y para qué sirve.', concepto_titulo='¿Qué es Arduino?', concepto_descripcion='Arduino es una plataforma electrónica de código abierto basada en hardware y software libres, flexibles y fáciles de usar. Permite crear proyectos interactivos utilizando una placa programable.', codigo_titulo='HolaArduino.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n  Serial.begin(9600);\n}\n\nvoid loop() {\n  Serial.println("Hola Arduino");\n  delay(1000);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué función se utiliza para inicializar la comunicación serie en el entorno de Arduino?', quiz_mensaje_correcto='¡Correcto! Serial.begin() establece la velocidad.', quiz_mensaje_incorrecto='Incorrecto. Es Serial.begin(9600).' WHERE id_tutorial = 1;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(1, '⚙️', 'pinMode(pin, mode)', 'Configura el pin especificado como entrada o salida.', 'Se utiliza OUTPUT para entregar voltaje e INPUT para leer componentes.'),
(1, '💡', 'digitalWrite(pin, value)', 'Escribe un valor HIGH (5V) o LOW (0V) en un pin digital.', 'Fija el voltaje del pin configurado como salida.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(1, 'Serial.start()', FALSE), (1, 'Serial.begin(9600)', TRUE), (1, 'Serial.open()', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 2', titulo='2. Placa Arduino', subtitulo='Partes principales de la placa y conexiones.', concepto_titulo='Anatomía de la Placa Arduino UNO', concepto_descripcion='La placa Arduino UNO reúne todos los elementos necesarios para controlar un circuito electrónico con el microcontrolador ATmega328P.', codigo_titulo='PruebaAlimentacion.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n  pinMode(13, OUTPUT);\n}\n\nvoid loop() {\n  digitalWrite(13, HIGH);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Cuál es la función principal del pin GND en la placa Arduino?', quiz_mensaje_correcto='¡Excelente! GND representa la masa o referencia de cero voltios.', quiz_mensaje_incorrecto='Incorrecto. GND es la conexión a tierra / masa.' WHERE id_tutorial = 2;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(2, '🔌', 'Pines de Alimentación (5V / 3.3V / GND)', 'Entregan energía eléctrica y tierra.', 'GND representa el punto de referencia de cero voltios.'),
(2, '🔢', 'Pines Digitales (0 a 13)', 'Operan en dos estados posibles: HIGH o LOW.', 'Se usan para componentes de salida o entrada.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(2, 'Suministrar 5 voltios de corriente continua', FALSE), (2, 'Servir como conexión a tierra / masa para cerrar el circuito', TRUE), (2, 'Reiniciar la ejecución del programa', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 3', titulo='3. Arduino IDE', subtitulo='Programa utilizado para escribir códigos.', concepto_titulo='Entorno de Desarrollo Integrado (IDE)', concepto_descripcion='El Arduino IDE es la herramienta oficial de software que permite escribir código fuente, verificar la sintaxis y compilar.', codigo_titulo='EstructuraIde.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué botón del Arduino IDE comprueba si el código tiene errores?', quiz_mensaje_correcto='¡Correcto! El botón Verificar compila el código sin subirlo.', quiz_mensaje_incorrecto='Incorrecto. Se usa el botón Verificar.' WHERE id_tutorial = 3;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(3, '✔️', 'Botón Verificar (Compilar)', 'Comprueba que la sintaxis no contenga errores.', 'Traduce C++ a lenguaje máquina binario.'),
(3, '➡️', 'Botón Subir (Cargar)', 'Transfiere el programa compilado a la placa por USB.', 'Borra el programa anterior y carga el nuevo.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(3, 'Verificar (Tilde)', TRUE), (3, 'Subir (Flecha)', FALSE), (3, 'Monitor Serie', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 4', titulo='4. Estructura del programa', subtitulo='Aprendé cómo funcionan setup() y loop().', concepto_titulo='Estructura Básica de un Sketch', concepto_descripcion='Todo programa requiere void setup() para inicializar y void loop() para el bucle infinito.', codigo_titulo='EstructuraBase.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n  pinMode(13, OUTPUT);\n}\n\nvoid loop() {\n  digitalWrite(13, HIGH);\n  delay(1000);\n  digitalWrite(13, LOW);\n  delay(1000);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Cuántas veces se ejecuta el bloque de código contenido en void setup()?', quiz_mensaje_correcto='¡Exacto! Se ejecuta una sola vez.', quiz_mensaje_incorrecto='Incorrecto. Corre solamente una vez al inicio.' WHERE id_tutorial = 4;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(4, '⚙️', 'void setup()', 'Bloque de configuración inicial.', 'Se ejecuta una sola vez al encender o reiniciar.'),
(4, '🔄', 'void loop()', 'Bloque de ciclo infinito.', 'Contiene la lógica principal del proyecto.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(4, 'Una sola vez al arrancar la placa', TRUE), (4, 'Se repite infinitamente', FALSE), (4, 'Se ejecuta cada 10 segundos', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 5', titulo='5. Variables', subtitulo='Uso de datos dentro de Arduino.', concepto_titulo='Almacenamiento y Tipos de Datos', concepto_descripcion='Las variables son espacios reservados en la memoria RAM para guardar valores numéricos o de texto.', codigo_titulo='UsoDeVariables.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='int pinLED = 13;\nint tiempoPausa = 500;\n\nvoid setup() {\n  pinMode(pinLED, OUTPUT);\n}\n\nvoid loop() {\n  digitalWrite(pinLED, HIGH);\n  delay(tiempoPausa);\n  digitalWrite(pinLED, LOW);\n  delay(tiempoPausa);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué tipo de dato se utiliza habitualmente para variables que almacenan el número de un pin?', quiz_mensaje_correcto='¡Muy bien! int es para números enteros.', quiz_mensaje_incorrecto='Incorrecto. Se usa int.' WHERE id_tutorial = 5;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(5, '🔢', 'int (Entero)', 'Almacena números enteros positivos y negativos.', 'Ocupa 2 bytes en placas de 8 bits.'),
(5, '⏱️', 'unsigned long', 'Entero largo positivo para medir tiempos.', 'Ideal para usar con millis().');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(5, 'int', TRUE), (5, 'float', FALSE), (5, 'String', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 6', titulo='6. Entradas y salidas', subtitulo='Control de componentes mediante Arduino.', concepto_titulo='Pines Digitales: Entradas y Salidas', concepto_descripcion='Se categorizan como OUTPUT para enviar corriente o INPUT para medir voltaje externo.', codigo_titulo='EntradaSalida.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinBoton = 2;\nconst int pinLED = 13;\n\nvoid setup() {\n  pinMode(pinBoton, INPUT);\n  pinMode(pinLED, OUTPUT);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='Si conectas un buzzer emisor de sonido a un pin digital, ¿cómo se configura?', quiz_mensaje_correcto='¡Correcto! Ejecutan una acción recibiendo señal.', quiz_mensaje_incorrecto='Incorrecto. Se configura como OUTPUT.' WHERE id_tutorial = 6;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(6, '📤', 'OUTPUT (Salida)', 'Emite señales eléctricas desde Arduino.', 'Entrega hasta 40 mA.'),
(6, '📥', 'INPUT (Entrada)', 'Recibe señales eléctricas hacia Arduino.', 'Presenta alta impedancia.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(6, 'OUTPUT', TRUE), (6, 'INPUT', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 7', titulo='7. Encender LED', subtitulo='Primer proyecto práctico con Arduino.', concepto_titulo='Circuito Básico de Parpadeo de LED', concepto_descripcion='Aprende a conectar un LED con una resistencia de protección de 220 Ohms.', codigo_titulo='BlinkLED.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='int ledPin = 13;\n\nvoid setup() {\n  pinMode(ledPin, OUTPUT);\n}\n\nvoid loop() {\n  digitalWrite(ledPin, HIGH);\n  delay(1000);\n  digitalWrite(ledPin, LOW);\n  delay(1000);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Cuántos milisegundos se indican en delay() para medio segundo?', quiz_mensaje_correcto='¡Excelente! 500 ms es medio segundo.', quiz_mensaje_incorrecto='Incorrecto. Son 500 milisegundos.' WHERE id_tutorial = 7;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(7, '⏱️', 'delay(ms)', 'Detiene la ejecución los milisegundos indicados.', '1000 ms equivalen a 1 segundo.'),
(7, '⚡', 'digitalWrite(pin, HIGH / LOW)', 'Alterna entre 5V y 0V.', 'Genera el efecto visual parpadeante.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(7, '500', TRUE), (7, '50', FALSE), (7, '5000', FALSE);


UPDATE tutoriales SET badge='PRINCIPIANTE - TUTORIAL 8', titulo='8. Pulsadores', subtitulo='Uso de botones para controlar Arduino.', concepto_titulo='Lectura Digital con Pulsadores', concepto_descripcion='Los pulsadores permiten detectar interacciones cerrando el circuito eléctrico.', codigo_titulo='ControlBoton.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinBoton = 2;\nconst int pinLED = 13;\n\nvoid setup() {\n  pinMode(pinBoton, INPUT);\n  pinMode(pinLED, OUTPUT);\n}\n\nvoid loop() {\n  int estado = digitalRead(pinBoton);\n  if (estado == HIGH) {\n    digitalWrite(pinLED, HIGH);\n  } else {\n    digitalWrite(pinLED, LOW);\n  }\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué función devuelve HIGH o LOW al consultar el estado de un botón?', quiz_mensaje_correcto='¡Correcto! digitalRead() obtiene el nivel lógico.', quiz_mensaje_incorrecto='Incorrecto. Se utiliza digitalRead().' WHERE id_tutorial = 8;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(8, '🔍', 'digitalRead(pin)', 'Lee el nivel de voltaje del pin digital.', 'Devuelve HIGH o LOW.'),
(8, '🔘', 'INPUT_PULLUP', 'Activa la resistencia interna de la placa.', 'Elimina la necesidad de resistencias externas.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(8, 'digitalRead()', TRUE), (8, 'digitalWrite()', FALSE), (8, 'analogRead()', FALSE);


UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 9', titulo='9. Condicionales', subtitulo='Tomar decisiones con if, else if y else.', concepto_titulo='Toma de Decisiones y Lógica Booleana', concepto_descripcion='Permiten evaluar condiciones en tiempo real ejecutando código según verdadero o falso.', codigo_titulo='ControlNivelLed.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinBoton = 2;\nconst int pinLedVerde = 12;\nconst int pinLedRojo = 13;\n\nvoid setup() {\n  pinMode(pinBoton, INPUT);\n  pinMode(pinLedVerde, OUTPUT);\n  pinMode(pinLedRojo, OUTPUT);\n}\n\nvoid loop() {\n  int estadoBoton = digitalRead(pinBoton);\n  if (estadoBoton == HIGH) {\n    digitalWrite(pinLedVerde, HIGH);\n    digitalWrite(pinLedRojo, LOW);\n  } else {\n    digitalWrite(pinLedVerde, LOW);\n    digitalWrite(pinLedRojo, HIGH);\n  }\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué bloque se ejecuta cuando la condición del if resulta falsa?', quiz_mensaje_correcto='¡Excelente! Salta al bloque else.', quiz_mensaje_incorrecto='Incorrecto. Se ejecuta el else.' WHERE id_tutorial = 9;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(9, '🔀', 'if (condición)', 'Evalúa expresión lógica.', 'Ejecuta si es true.'),
(9, '⚖️', 'Operadores (==, !=, >, <)', 'Compara valores.', 'Cuidado con confundir == con =.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(9, 'El bloque encerrado dentro del else', TRUE), (9, 'void setup()', FALSE), (9, 'Se detiene la corriente', FALSE);
-- TUTORIAL 10
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 10', titulo='10. Bucles', subtitulo='Repetición iterativa con for y while.', concepto_titulo='Estructuras Repetitivas (Loops)', concepto_descripcion='Ejecutan bloques de instrucciones reiteradas veces de forma automática.', codigo_titulo='SecuenciaBarridoLED.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n  for (int pin = 2; pin <= 6; pin++) {\n    pinMode(pin, OUTPUT);\n  }\n}\n\nvoid loop() {\n  for (int pin = 2; pin <= 6; pin++) {\n    digitalWrite(pin, HIGH);\n    delay(100);\n    digitalWrite(pin, LOW);\n  }\n}', quiz_pregunta='¿Qué estructura se usa cuando se conoce la cantidad exacta de repeticiones?', quiz_mensaje_correcto='¡Muy bien! El bucle for incluye contador.', quiz_mensaje_incorrecto='Incorrecto. Se usa for.' WHERE id_tutorial = 10;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(10, '🔄', 'for (inicio; condición; incremento)', 'Bucle con contador integrado.', 'Ideal para iteraciones fijas.'),
(10, '⏳', 'while (condición)', 'Repite mientras la condición sea verdadera.', 'Se evalúa al inicio.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(10, 'Bucle for', TRUE), (10, 'Estructura if', FALSE), (10, 'delay()', FALSE);


-- TUTORIAL 11
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 11', titulo='11. Sensores', subtitulo='Recolección de datos físicos con Arduino.', concepto_titulo='Transducción y Captura del Entorno', concepto_descripcion='Un sensor convierte magnitudes físicas en señales eléctricas procesables.', codigo_titulo='LecturaLDR.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinLDR = A0;\nconst int pinLedAlarma = 13;\n\nvoid setup() {\n  pinMode(pinLedAlarma, OUTPUT);\n  Serial.begin(9600);\n}\n\nvoid loop() {\n  int valorLuz = analogRead(pinLDR);\n  if (valorLuz < 300) {\n    digitalWrite(pinLedAlarma, HIGH);\n  } else {\n    digitalWrite(pinLedAlarma, LOW);\n  }\n  delay(500);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué función cumple un sensor en un circuito?', quiz_mensaje_correcto='¡Correcto! Traducen magnitudes físicas en señales eléctricas.', quiz_mensaje_incorrecto='Incorrecto. Convierten variables físicas en electricidad.' WHERE id_tutorial = 11;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(11, '', 'Sensores Digitales', 'Valores discretos HIGH / LOW.', 'Ej: PIR o finales de carrera.'),
(11, '', 'Sensores Analógicos', 'Variaciones continuas de voltaje.', 'Ej: LDR o NTC.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(11, 'Convertir variables físicas en señales eléctricas', TRUE), (11, 'Aumentar voltaje USB', FALSE), (11, 'Guardar código en FLASH', FALSE);


-- TUTORIAL 12
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 12', titulo='12. Lecturas analógicas', subtitulo='Muestreo con el Conversor Analógico a Digital (ADC).', concepto_titulo='Conversión Analógica a Digital (ADC)', concepto_descripcion='El ADC de 10 bits divide el rango de 0V a 5V en 1024 niveles discretos (0 a 1023).', codigo_titulo='VoltímetroSimple.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinAnalogo = A0;\n\nvoid setup() {\n  Serial.begin(9600);\n}\n\nvoid loop() {\n  int valorADC = analogRead(pinAnalogo);\n  float voltaje = valorADC * (5.0 / 1023.0);\n  Serial.println(voltaje);\n  delay(300);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué valor devuelve analogRead() con una tensión exacta de 5V?', quiz_mensaje_correcto='¡Excelente! 1023 es el nivel máximo del ADC de 10 bits.', quiz_mensaje_incorrecto='Incorrecto. El rango va de 0 a 1023.' WHERE id_tutorial = 12;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(12, '', 'analogRead(pin)', 'Mide tensión y devuelve de 0 a 1023.', 'Toma aprox 100 microsegundos.'),
(12, '', 'Pines A0 a A5', 'Pines de entrada analógica.', 'Reconfigurables como digitales si es necesario.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(12, '1023', TRUE), (12, '255', FALSE), (12, '500', FALSE);


-- TUTORIAL 13
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 13', titulo='13. Potenciómetro', subtitulo='Resistencias variables y función map().', concepto_titulo='Divisores de Tensión Ajustables y Escalado', concepto_descripcion='El potenciómetro actúa como divisor de tensión variable regulando parámetros.', codigo_titulo='DimmerLED.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinPotencimetro = A0;\nconst int pinLedPWM = 9;\n\nvoid setup() {\n  pinMode(pinLedPWM, OUTPUT);\n}\n\nvoid loop() {\n  int valorEntrada = analogRead(pinPotencimetro);\n  int brillo = map(valorEntrada, 0, 1023, 0, 255);\n  analogWrite(pinLedPWM, brillo);\n  delay(10);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué función re-escala el rango 0-1023 al rango 0-255?', quiz_mensaje_correcto='¡Excelente! map() realiza el escalado proporcional.', quiz_mensaje_incorrecto='Incorrecto. Se utiliza map().' WHERE id_tutorial = 13;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(13, '', 'map(val, in_min, in_max, out_min, out_max)', 'Re-escala proporcionalmente un valor.', 'Evita pérdida de proporción.'),
(13, '', 'analogWrite(pin, val)', 'Genera PWM en pines compatibles.', 'Acepta valores de 0 a 255.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(13, 'map()', TRUE), (13, 'convert()', FALSE), (13, 'scaleValue()', FALSE);


-- TUTORIAL 14
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 14', titulo='14. Sensor HC-SR04', subtitulo='Medición ultrasónica de distancia.', concepto_titulo='Principio de Funcionamiento del Ultrasonido', concepto_descripcion='Mide distancias de 2cm a 400cm mediante ecolocalización de ondas acústicas.', codigo_titulo='MedidorUltrasonico.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='const int pinTrig = 9;\nconst int pinEcho = 10;\n\nvoid setup() {\n  pinMode(pinTrig, OUTPUT);\n  pinMode(pinEcho, INPUT);\n  Serial.begin(9600);\n}\n\nvoid loop() {\n  digitalWrite(pinTrig, LOW);\n  delayMicroseconds(2);\n  digitalWrite(pinTrig, HIGH);\n  delayMicroseconds(10);\n  digitalWrite(pinTrig, LOW);\n  long duracion = pulseIn(pinEcho, HIGH);\n  int distancia = duracion / 58;\n  Serial.println(distancia);\n  delay(200);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Cuál es la función del pin Trigger en el HC-SR04?', quiz_mensaje_correcto='¡Excelente! Trigger emite la onda ultrasónica.', quiz_mensaje_incorrecto='Incorrecto. Trigger dispara la onda y Echo escucha.' WHERE id_tutorial = 14;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(14, '', 'pulseIn(pin, HIGH)', 'Mide microsegundos de duración de un pulso.', 'Detecta el tiempo de retorno.'),
(14, '', 'Pin Trigger', 'Emite la ráfaga ultrasónica.', 'Requiere pulso HIGH de 10 µs.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(14, 'Emitir el pulso de sonido ultrasónico hacia el ambiente', TRUE), (14, 'Escuchar y recibir el rebote del eco', FALSE), (14, 'Suministrar corriente de 5V', FALSE);


-- TUTORIAL 15
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 15', titulo='15. Servomotores', subtitulo='Control angular preciso con Servo.h.', concepto_titulo='Servomecanismos y Control de Posición', concepto_descripcion='Permite posicionar su eje en un ángulo exacto entre 0° y 180°.', codigo_titulo='ControlServomotor.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <Servo.h>\nServo miServo;\n\nvoid setup() {\n  miServo.attach(9);\n}\n\nvoid loop() {\n  for (int angulo = 0; angulo <= 180; angulo += 10) {\n    miServo.write(angulo);\n    delay(50);\n  }\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué librería estándar se incluye para controlar servomotores?', quiz_mensaje_correcto='¡Muy bien! Se incluye <Servo.h>.', quiz_mensaje_incorrecto='Incorrecto. Se utiliza <Servo.h>.' WHERE id_tutorial = 15;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(15, '', '#include <Servo.h>', 'Librería para control de servos.', 'Permite hasta 12 servos en Arduino UNO.'),
(15, '', 'miServo.write(grados)', 'Desplaza el eje al ángulo indicado.', 'Acepta valores de 0 a 180.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(15, '<Servo.h>', TRUE), (15, '<MotorController.h>', FALSE), (15, '<EEPROM.h>', FALSE);


-- TUTORIAL 16
UPDATE tutoriales SET badge='INTERMEDIO - TUTORIAL 16', titulo='16. Monitor Serial', subtitulo='Diagnóstico y depuración por UART/USB.', concepto_titulo='Comunicación Serie UART', concepto_descripcion='Permite establecer comunicación bidireccional de texto entre PC y Arduino.', codigo_titulo='ComandosSeriales.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n  Serial.begin(9600);\n}\n\nvoid loop() {\n  if (Serial.available() > 0) {\n    char comando = Serial.read();\n    Serial.println(comando);\n  }\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué método inicializa el puerto serie?', quiz_mensaje_correcto='¡Correcto! Serial.begin() fija la velocidad.', quiz_mensaje_incorrecto='Incorrecto. Se usa Serial.begin(9600).' WHERE id_tutorial = 16;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(16, '', 'Serial.begin(baudios)', 'Inicializa el puerto serie.', 'Estándar universal a 9600 baudios.'),
(16, '', 'Serial.println()', 'Envía datos formateados en texto con salto de línea.', 'Ideal para depuración.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(16, 'Serial.begin(9600)', TRUE), (16, 'Serial.start()', FALSE), (16, 'Serial.init()', FALSE);


-- TUTORIAL 17
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 17', titulo='17. Librerías', subtitulo='Modularidad y extensión con librerías de Arduino.', concepto_titulo='Modularidad y Reutilización de Código', concepto_descripcion='Empaquetan funciones complejas y protocolos para hardware sofisticado.', codigo_titulo='UsoLibreriaDHT.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <DHT.h>\n#define DHTPIN 2\n#define DHTTYPE DHT11\nDHT dht(DHTPIN, DHTTYPE);\n\nvoid setup() {\n  Serial.begin(9600);\n  dht.begin();\n}\n\nvoid loop() {\n  float temp = dht.readTemperature();\n  Serial.println(temp);\n  delay(2000);\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué directiva incorpora una librería externa?', quiz_mensaje_correcto='¡Excelente! #include incorpora las cabeceras.', quiz_mensaje_incorrecto='Incorrecto. Se usa #include.' WHERE id_tutorial = 17;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(17, '', '#include <Libreria.h>', 'Importa la cabecera del módulo.', 'Da acceso a clases y métodos.'),
(17, '', 'Instanciación', 'Crea variables globales de hardware.', 'Define pines y modelos.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(17, '#include <Libreria.h>', TRUE), (17, '#import <Libreria.h>', FALSE), (17, '#define Libreria.h', FALSE);


-- TUTORIAL 18
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 18', titulo='18. Pantallas LCD', subtitulo='Interfaz HMI con pantallas 16x2.', concepto_titulo='Despliegue Visual de Información', concepto_descripcion='Módulos alfanuméricos para imprimir caracteres e indicadores.', codigo_titulo='PantallaLCD16x2.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <LiquidCrystal.h>\nLiquidCrystal lcd(12, 11, 5, 4, 3, 2);\n\nvoid setup() {\n  lcd.begin(16, 2);\n  lcd.print("ARDUNOVA");\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué coordenadas posicionan el cursor en la segunda fila desde el inicio?', quiz_mensaje_correcto='¡Correcto! Columna 0, Fila 1.', quiz_mensaje_incorrecto='Incorrecto. Es (0, 1).' WHERE id_tutorial = 18;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(18, '', 'lcd.setCursor(col, fila)', 'Posiciona el cursor.', 'Usa coordenadas de base cero (0 a 15, 0 a 1).'),
(18, '', 'lcd.clear()', 'Borra completamente la pantalla.', 'Sitúa el cursor en (0,0).');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(18, '(0, 1)', TRUE), (18, '(1, 2)', FALSE), (18, '(2, 1)', FALSE);


-- TUTORIAL 19
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 19', titulo='19. Comunicación Bluetooth', subtitulo='Inalámbrica punto a punto con HC-05 / HC-06.', concepto_titulo='Redes PAN Inalámbricas', concepto_descripcion='Vincula Arduino con dispositivos móviles vía Bluetooth serie.', codigo_titulo='ControlBluetooth.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <SoftwareSerial.h>\nSoftwareSerial miBT(10, 11);\n\nvoid setup() {\n  miBT.begin(9600);\n}\n\nvoid loop() {\n  if (miBT.available()) {\n    char dato = miBT.read();\n  }\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Para qué sirve SoftwareSerial?', quiz_mensaje_correcto='¡Excelente! Emula puertos serie secundarios.', quiz_mensaje_incorrecto='Incorrecto. Crea puertos serie en pines digitales.' WHERE id_tutorial = 19;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(19, '', 'SoftwareSerial(rx, tx)', 'Emula un puerto serie secundario.', 'Libera pines hardware 0 y 1.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(19, 'Para crear un puerto serie secundario en pines digitales', TRUE), (19, 'Para aumentar la potencia a 100m', FALSE);


-- TUTORIAL 20
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 20', titulo='20. Comunicación Wi-Fi', subtitulo='IoT con ESP8266 y ESP32.', concepto_titulo='Internet de las Cosas (IoT)', concepto_descripcion='Conecta sensores a internet mediante microcontroladores Wi-Fi.', codigo_titulo='ConexionWiFiIoT.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <WiFi.h>\nconst char* ssid = "Red";\nconst char* pass = "Clave";\n\nvoid setup() {\n  WiFi.begin(ssid, pass);\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué método de la librería WiFi inicia la autenticación?', quiz_mensaje_correcto='¡Correcto! WiFi.begin() inicia el enlace.', quiz_mensaje_incorrecto='Incorrecto. Se utiliza WiFi.begin().' WHERE id_tutorial = 20;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(20, '', 'WiFi.begin(ssid, pass)', 'Conecta el módulo a la red inalámbrica.', 'Inicia negociación DHCP.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(20, 'WiFi.begin(ssid, password)', TRUE), (20, 'WiFi.connect(ssid, password)', FALSE);


-- TUTORIAL 21
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 21', titulo='21. Comunicación I2C', subtitulo='Bus serie de dos hilos (SDA / SCL).', concepto_titulo='Bus de Comunicación I2C', concepto_descripcion='Utiliza líneas SDA y SCL para conectar múltiples dispositivos.', codigo_titulo='LCD_I2C.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <Wire.h>\n#include <LiquidCrystal_I2C.h>\nLiquidCrystal_I2C lcd(0x27, 16, 2);\n\nvoid setup() {\n  lcd.init();\n  lcd.backlight();\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Cuáles son los dos nombres de líneas de señal para I2C?', quiz_mensaje_correcto='¡Excelente! I2C usa SDA y SCL.', quiz_mensaje_incorrecto='Incorrecto. Son SDA y SCL.' WHERE id_tutorial = 21;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(21, '', '#include <Wire.h>', 'Controla transmisiones I2C.', 'En Arduino UNO usa A4 (SDA) y A5 (SCL).');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(21, 'SDA (Datos) y SCL (Reloj)', TRUE), (21, 'TX y RX', FALSE);


-- TUTORIAL 22
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 22', titulo='22. Comunicación SPI', subtitulo='Protocolo sincrónico de alta velocidad.', concepto_titulo='Bus SPI (Serial Peripheral Interface)', concepto_descripcion='Bus sincrónico de cuatro hilos para tarjetas SD y pantallas.', codigo_titulo='LecturaSD.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <SPI.h>\n#include <SD.h>\nvoid setup() {\n  SD.begin(10);\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué pin selecciona cuál esclavo debe comunicarse?', quiz_mensaje_correcto='¡Muy bien! El pin SS habilita el esclavo.', quiz_mensaje_incorrecto='Incorrecto. Se utiliza SS / CS.' WHERE id_tutorial = 22;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(22, '', 'MOSI, MISO, SCK y SS', 'Líneas físicas SPI.', 'Alta velocidad de transferencia.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(22, 'SS / CS (Slave Select)', TRUE), (22, 'SCK (Serial Clock)', FALSE);


-- TUTORIAL 23
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 23', titulo='23. Varios componentes', subtitulo='Integración simultánea de sensores y actuadores.', concepto_titulo='Arquitectura de Sistemas Integrados', concepto_descripcion='Coordinación de múltiples periféricos compartiendo GND.', codigo_titulo='EstacionMeteorologica.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='#include <Wire.h>\n#include <DHT.h>\nvoid setup() {\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Por qué es fundamental unir las tierras (GND) en un circuito multi-componente?', quiz_mensaje_correcto='¡Correcto! Establece una referencia de 0V común.', quiz_mensaje_incorrecto='Incorrecto. Se requiere para la referencia común de voltaje.' WHERE id_tutorial = 23;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(23, '', 'GND Unificado', 'Masa común para todos los módulos.', 'Indispensable para cerrar circuitos.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(23, 'Para establecer una referencia de tensión de 0V común', TRUE), (23, 'Para duplicar velocidad', FALSE);


-- TUTORIAL 24
UPDATE tutoriales SET badge='AVANZADO - TUTORIAL 24', titulo='24. Solución de errores', subtitulo='Estrategias de depuración y diagnóstico.', concepto_titulo='Depuración (Debugging)', concepto_descripcion='Identificación de errores de sintaxis, lógica y fallos de hardware.', codigo_titulo='Debugging.ino', codigo_lenguaje='C++ / Arduino', codigo_fuente='void setup() {\n  Serial.begin(9600);\n  Serial.println("[DEBUG] Inicio...");\n}\n\nvoid loop() {\n}', wokwi_project_id=NULL, wokwi_titulo=NULL, wokwi_instruccion=NULL, wokwi_nota=NULL, quiz_pregunta='¿Qué método sencillo permite verificar por qué rama pasa el programa?', quiz_mensaje_correcto='¡Excelente! Las trazas con Serial.println() son claves.', quiz_mensaje_incorrecto='Incorrecto. Se imprimen mensajes en consola.' WHERE id_tutorial = 24;

INSERT INTO tutorial_funciones (id_tutorial, icono, titulo, descripcion, detalle) VALUES
(24, '', 'Serial.println() para Debugging', 'Imprime marcas de control.', 'Permite rastrear la ejecución del código.');

INSERT INTO tutorial_quiz_opciones (id_tutorial, texto_opcion, es_correcta) VALUES
(24, 'Imprimir mensajes informativos en la consola mediante Serial.println()', TRUE), (24, 'Desconectar cable USB', FALSE);


-- PROYECTOS 


CREATE TABLE IF NOT EXISTS proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    categoria_p VARCHAR(20) NOT NULL,
    titulo VARCHAR(150) NOT NULL DEFAULT '',
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL DEFAULT '',
    enlace VARCHAR(150) NOT NULL DEFAULT ''
);

-- Carga de los 12 proyectos
INSERT INTO proyectos
(id_proyecto, categoria_p, titulo, descripcion, imagen, enlace)
VALUES
(1, 'Principiante', 'Parpadeo de LED (Blink)', 'El clásico Hola Mundo de la electrónica: aprendé a controlar un LED con Arduino.', '../assets/img/lcd.jpg', 'ledblink.php'),

(2, 'Intermedio', 'Pantalla LCD Dinámica', 'Aprende a conectar y mostrar texto animado en una pantalla LCD 16x2 vía I2C.', '../assets/img/lcd-dinamica.jpg', 'lcddinamica.php'),

(3, 'Intermedio', 'Semáforo Avanzado con Paso Peatonal', 'Construí un semáforo vehicular inteligente sincronizado con cruce peatonal por demanda.', '../assets/img/semaforo-arduino.png', 'semaforo.php'),

(4, 'Intermedio', 'Sensor Ultrasónico de Distancia', 'Medí distancias precisas a objetos en centímetros utilizando el módulo HC-SR04.', '../assets/img/ultrasonico.jpg', 'ultrasonico.php'),

(5, 'Intermedio', 'Domótica Básica', 'Automatizá luces y monitoreá presencia utilizando sensores PIR, LDR y un relé de potencia.', '../assets/img/domotica.jpg', 'domotica.php'),

(6, 'Principiante', 'Control de LED con Pulsador', 'Aprendé a leer entradas digitales con una resistencia Pull-Down para encender un LED.', '../assets/img/ledBoton.jpg', 'ledboton.php'),

(7, 'Principiante', 'Lectura de Potenciómetro', 'Leé entradas analógicas con un potenciómetro y modificá la velocidad de parpadeo de un LED.', '../assets/img/potenciometro.jpg', 'potenciometro.php'),

(8, 'Principiante', 'Sensor de Luz (LDR)', 'Detectá variaciones de luz ambiental usando una fotorresistencia LDR y activá una luz nocturna.', '../assets/img/sensorLuz.jpg', 'sensor_luz.php'),

(9, 'Intermedio', 'Sistema de Riego Automático', 'Monitoreá la humedad del suelo con un sensor FC-28 y activá el riego automático con una bomba.', '../assets/img/sistemaDeRiego.jpg', 'riego_automatico.php'),

(10, 'Intermedio', 'Auto Seguidor de Línea', 'Construí un robot móvil autónomo capaz de rastrear una línea negra usando sensores IR.', '../assets/img/seguidorLinea.jpg', 'seguidor_linea.php'),

(11, 'Intermedio', 'Robot Esquivador de Obstáculos', 'Creá un vehículo robótico que detecte y evite objetos de forma autónoma con ultrasonido.', '../assets/img/robotobstaculos.jpg', 'robot_obstaculos.php'),

(12, 'Principiante', 'Servomotor con Arduino', 'Aprende a posicionar el eje de un servomotor SG90 en ángulos específicos de 0° a 180°.', '../assets/img/servomotor.jpg', 'servomotor.php')

ON DUPLICATE KEY UPDATE
categoria_p = VALUES(categoria_p),
titulo = VALUES(titulo),
descripcion = VALUES(descripcion),
imagen = VALUES(imagen),
enlace = VALUES(enlace);

-- RELACIÓN ENTRE PROGRESO Y PROYECTOS


ALTER TABLE progreso
    MODIFY COLUMN id_tutorial INT NULL;

ALTER TABLE progreso
    ADD COLUMN id_proyecto INT NULL;

ALTER TABLE progreso
    ADD CONSTRAINT unique_usuario_proyecto
    UNIQUE (id_usuarios, id_proyecto);

ALTER TABLE progreso
    ADD CONSTRAINT fk_progreso_proyecto
    FOREIGN KEY (id_proyecto)
    REFERENCES proyectos(id_proyecto)
    ON DELETE CASCADE ON UPDATE CASCADE;