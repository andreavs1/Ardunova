document.addEventListener('DOMContentLoaded', () => {
    loadLesson();
    window.addEventListener('popstate', loadLesson);
});

async function loadLesson() {
    const app = document.getElementById('app-tutorial');
    if (!app) return;

    const urlParams = new URLSearchParams(window.location.search);
    const lessonId = urlParams.get('id') || '17';

    try {
        const response = await fetch(`obtener_tutorial_avanzado.php?id=${lessonId}`);
        const rawText = await response.text();

        if (!response.ok) {
            throw new Error(`No se pudo acceder al tutorial (Código HTTP: ${response.status})`);
        }

        let data;
        try {
            data = JSON.parse(rawText);
        } catch (e) {
            console.error("El servidor no devolvió un JSON válido:", rawText);
            throw new Error("El archivo PHP devolvió un error de servidor o HTML en lugar de JSON. Revisá la consola.");
        }

        if (!data || data.error) {
            app.innerHTML = `
                <div class="container my-5 text-center">
                    <div class="alert alert-warning p-4 rounded-4 shadow-sm">
                        <h5 class="fw-bold">⚠️ Tutorial #${lessonId} no encontrado</h5>
                        <p class="mb-0 small text-secondary">Verificá que el número de ID corresponda a este nivel.</p>
                        <a href="?id=17" class="btn btn-danger btn-sm mt-3">Ir al Tutorial 17</a>
                    </div>
                </div>`;
            return;
        }

        const formatBold = (text) => text ? text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') : '';

        const rawOptions = data.quiz?.opciones || [];
        const shuffledQuizOptions = Array.from(
            new Map(rawOptions.map(item => [item.texto, item])).values()
        );

        app.innerHTML = `
            <div class="container py-2" style="max-width: 1000px;">
                
                <style>
                    :root {
                        --ardunova-dark: #0b132b;
                        --ardunova-red: #ef4444;
                    }

                    .hero-ardunova {
                        background: linear-gradient(135deg, #0b132b 0%, #1c1917 60%, #450a0a 100%);
                        border: 1px solid rgba(239, 68, 68, 0.25);
                        box-shadow: 0 0 25px rgba(239, 68, 68, 0.15);
                    }

                    .card-glow {
                        background: #ffffff;
                        border: 1px solid #e2e8f0;
                        border-radius: 18px;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .card-glow:hover {
                        transform: translateY(-4px);
                        border-color: var(--ardunova-red);
                        box-shadow: 0 12px 30px -10px rgba(239, 68, 68, 0.25) !important;
                    }

                    .btn-details-custom {
                        background: #f8fafc;
                        border: 1px solid #e2e8f0;
                        color: #be123c;
                        font-size: 0.85rem;
                        font-weight: 600;
                        padding: 8px 14px;
                        border-radius: 10px;
                        transition: all 0.25s ease;
                        display: inline-flex;
                        align-items: center;
                        justify-content: space-between;
                        width: 100%;
                        cursor: pointer;
                        margin-top: 12px;
                    }

                    .details-box {
                        background: #f8fafc;
                        border-left: 4px solid var(--ardunova-red);
                        border-radius: 8px;
                        padding: 12px 16px;
                        font-size: 0.88rem;
                        color: #334155;
                    }

                    .code-glow {
                        background: #090d16;
                        border: 1px solid rgba(239, 68, 68, 0.3);
                        box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5);
                    }

                    .btn-ardunova {
                        background: linear-gradient(135deg, #dc2626, #b91c1c);
                        color: white;
                        border: none;
                        font-weight: 600;
                        border-radius: 12px;
                        transition: all 0.2s ease;
                    }

                    .btn-ardunova:disabled {
                        background: #94a3b8;
                        cursor: not-allowed;
                        opacity: 0.6;
                    }

                    .quiz-btn-interactive {
                        transition: all 0.25s ease;
                        border: 2px solid #e2e8f0;
                        background-color: #f8fafc;
                        border-radius: 12px;
                        font-weight: 500;
                    }
                </style>

                <!-- Header -->
                <header class="hero-ardunova rounded-4 p-4 p-md-5 mb-5 text-white">
                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                        <span class="badge px-3 py-2 rounded-pill bg-danger text-white border border-danger font-monospace" style="font-size: 0.8rem;">
                            ${data.badge || 'AVANZADO'}
                        </span>
                        ${data.completado ? `
                            <span class="badge px-3 py-2 rounded-pill bg-success text-white">
                                ✓ COMPLETADO
                            </span>
                        ` : ''}
                    </div>
                    <h1 class="fw-bold display-6 text-white mb-2">${data.titulo}</h1>
                    <p class="fs-6 text-light opacity-75 mb-0">${data.subtitulo}</p>
                </header>

                <!-- Concepto -->
                ${data.concepto_principal ? `
                <section class="card card-glow shadow-sm mb-4 p-4" style="border-left: 6px solid #ef4444 !important;">
                    <h2 class="h5 fw-bold text-dark mb-2">${data.concepto_principal.titulo}</h2>
                    <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                        ${formatBold(data.concepto_principal.descripcion)}
                    </p>
                </section>
                ` : ''}

                <!-- Funciones Clave -->
                ${data.funciones_clave && data.funciones_clave.length > 0 ? `
                <h3 class="h5 fw-bold text-dark mb-3">Especificaciones Clave</h3>
                <div class="row g-3 mb-5">
                    ${data.funciones_clave.map((item, index) => `
                        <div class="col-md-6">
                            <div class="card card-glow h-100 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="fs-3">${item.icono || '⚡'}</span>
                                        <h4 class="h6 fw-bold mb-0 text-dark font-monospace">${item.titulo}</h4>
                                    </div>
                                    <p class="text-secondary small mb-2">${item.descripcion}</p>
                                </div>
                                ${item.detalle ? `
                                <div>
                                    <button class="btn-details-custom" type="button" onclick="const el = document.getElementById('collapseDetalle_${index}'); el.style.display = (el.style.display === 'block') ? 'none' : 'block';">
                                        <span>ℹ️ Ver detalles técnicos</span>
                                        <span>▼</span>
                                    </button>
                                    <div class="details-box mt-2" id="collapseDetalle_${index}" style="display: none;">
                                        ${formatBold(item.detalle)}
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    `).join('')}
                </div>
                ` : ''}

                <!-- Código -->
                ${data.codigo_ejemplo ? `
                <section class="card code-glow rounded-4 mb-5 overflow-hidden shadow-lg">
                    <div class="card-header bg-black text-danger font-monospace py-3 px-4">
                        ${data.codigo_ejemplo.titulo}
                    </div>
                    <div class="card-body p-4 font-monospace text-light" style="font-size: 0.9rem; overflow-x: auto;">
                        <pre class="m-0"><code>${data.codigo_ejemplo.codigo}</code></pre>
                    </div>
                </section>
                ` : ''}

                <!-- Simulador -->
                ${data.simulador_wokwi ? `
                <section class="card card-glow shadow-sm mb-5 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                        <h3 class="h6 fw-bold mb-0 text-dark">🎮 ${data.simulador_wokwi.titulo}</h3>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success">● En Vivo</span>
                    </div>
                    <div class="card-body p-4 bg-light">
                        <p class="small text-muted mb-3">${formatBold(data.simulador_wokwi.instruccion)}</p>
                        <div class="ratio ratio-16x9 rounded-4 border border-2 border-danger shadow-sm bg-white overflow-hidden mb-3">
                            <iframe src="https://wokwi.com/projects/${data.simulador_wokwi.project_id}?embed=1" allow="autoplay"></iframe>
                        </div>
                        ${data.simulador_wokwi.nota ? `<div class="p-3 bg-white border rounded-3 text-secondary small">${formatBold(data.simulador_wokwi.nota)}</div>` : ''}
                    </div>
                </section>
                ` : ''}

                <!-- Quiz -->
                ${data.quiz ? `
                <section class="card card-glow shadow-sm p-4 mb-5" style="border-top: 5px solid #ef4444 !important;">
                    <span class="badge bg-danger bg-opacity-10 text-danger font-monospace mb-2" style="width: fit-content;">🧠 RETO DE CONOCIMIENTO</span>
                    <p class="fw-bold text-dark mb-3">${data.quiz.pregunta}</p>

                    <div class="d-flex flex-column gap-2 mb-3">
                        ${shuffledQuizOptions.map(opt => `
                            <button class="btn text-start p-3 quiz-btn-interactive" data-correct="${opt.es_correcta}">
                                ${opt.texto}
                            </button>
                        `).join('')}
                    </div>
                    <div id="quiz-feedback" class="small fw-bold mt-2"></div>
                </section>
                ` : ''}

                <footer class="d-flex justify-content-between align-items-center pt-4 border-top">
                    <button id="btn-prev" class="btn btn-outline-secondary px-3 px-md-4 py-2 rounded-3 fw-semibold" style="font-size: 0.85rem;">
                        ← <span class="d-none d-sm-inline">Lección </span>Anterior
                    </button>
                    <span class="text-muted font-monospace small px-2">Lección ${lessonId} de 24</span>
                    <button id="btn-next" class="btn btn-ardunova px-3 px-md-4 py-2" style="font-size: 0.85rem;" ${data.quiz && !data.completado ? 'disabled' : ''}>
                        <span class="d-none d-sm-inline">Siguiente </span>Lección →
                    </button>
                </footer>

            </div>
        `;

        const currentNum = parseInt(lessonId, 10);
        const btnNext = document.getElementById('btn-next');
        const btnPrev = document.getElementById('btn-prev');
        const quizBtns = document.querySelectorAll('.quiz-btn-interactive');
        const feedback = document.getElementById('quiz-feedback');

        let isQuizPassed = data.completado === true;
// Si el tutorial ya estaba completado, bloquear las respuestas.
if (data.completado) {
    quizBtns.forEach(button => {
        button.disabled = true;

        if (button.getAttribute('data-correct') === 'true') {
            button.classList.add('border-success', 'bg-success', 'bg-opacity-10');
        }
    });

    if (feedback) {
        feedback.className = "small fw-bold mt-2 text-success";
        feedback.textContent = "✓ ¡Este tutorial ya está completado!";
    }

    if (btnNext) {
        btnNext.disabled = false;
    }
}
        if (isQuizPassed && btnNext) {
            btnNext.disabled = false;
        }

        if (btnPrev) {
            if (currentNum <= 17) btnPrev.classList.add('disabled');
            btnPrev.addEventListener('click', () => {
                if (currentNum > 17) {
                    window.location.search = `?id=${currentNum - 1}`;
                }
            });
        }

        if (btnNext) {
            if (currentNum >= 24) {
                btnNext.textContent = 'Finalizar curso';
            }

            btnNext.addEventListener('click', async () => {
                if (data.quiz && !isQuizPassed) {
                    alert('Respondé correctamente el cuestionario para avanzar.');
                    return;
                }

                btnNext.disabled = true;

                try {
                    // Petición idéntica mandando JSON y credenciales de sesión
                    const respuesta = await fetch('../../../guardar_progreso.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        credentials: 'include', // <--- Envía la cookie PHPSESSID
                        body: JSON.stringify({ id_tutorial: currentNum })
                    });

                    const resultado = await respuesta.json();

                    if (resultado.ok) {
                        if (currentNum >= 24) {
                            window.location.href = '../perfil.php';
                        } else {
                            window.location.href = `?id=${currentNum + 1}`;
                        }
                    } else {
                        alert('No se pudo guardar el progreso: ' + (resultado.mensaje || ''));
                        btnNext.disabled = false;
                    }

                } catch (error) {
                    console.error('Error al guardar el progreso:', error);
                    alert('Ocurrió un error al guardar el progreso.');
                    btnNext.disabled = false;
                }
            });
        }

        if (quizBtns.length > 0 && feedback && data.quiz) {
            quizBtns.forEach(button => {
                button.addEventListener('click', () => {
if (data.completado) return;
                    const isCorrect = button.getAttribute('data-correct') === 'true';

                    quizBtns.forEach(btn => {
                        btn.style.backgroundColor = "#f8fafc";
                        btn.style.borderColor = "#e2e8f0";
                        btn.style.color = "#212529";
                    });

                    if (isCorrect) {
                        isQuizPassed = true;
                        button.style.backgroundColor = "#dcfce7";
                        button.style.borderColor = "#22c55e";
                        button.style.color = "#15803d";
                        feedback.className = "small fw-bold mt-2 text-success";
                        feedback.textContent = (data.quiz.mensaje_correcto || "¡Correcto!") + " ¡Ya podés avanzar a la siguiente lección!";
                        if (btnNext) btnNext.disabled = false;
                    } else {
                        isQuizPassed = false;
                        button.style.backgroundColor = "#fee2e2";
                        button.style.borderColor = "#ef4444";
                        button.style.color = "#b91c1c";
                        feedback.className = "small fw-bold mt-2 text-danger";
                        feedback.textContent = (data.quiz.mensaje_incorrecto || "Incorrecto.") + " Respondé correctamente para desbloquear la siguiente lección.";
                        if (btnNext) btnNext.disabled = true;
                    }
                });
            });
        }

    } catch (error) {
        const app = document.getElementById('app-tutorial');
        if (app) {
            app.innerHTML = `
                <div class="container my-5 text-center">
                    <div class="alert alert-danger p-4 rounded-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
                        <h5 class="fw-bold text-danger mb-2">⚠️ Error de Carga</h5>
                        <p class="mb-0 text-secondary small">${error.message}</p>
                    </div>
                </div>`;
        }
    }
}