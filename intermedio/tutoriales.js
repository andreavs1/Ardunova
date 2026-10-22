document.addEventListener('DOMContentLoaded', () => {
    loadLesson();
    window.addEventListener('popstate', loadLesson);
});

async function loadLesson() {
    const app = document.getElementById('app-tutorial');
    if (!app) return;

    const urlParams = new URLSearchParams(window.location.search);
    const lessonId = urlParams.get('id') || '9';

    try {
        const response = await fetch('tutoriales.json');
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: No se pudo cargar tutoriales.json`);
        }

        const database = await response.json();
        const data = database[lessonId];

        if (!data) {
            app.innerHTML = `
            <div class="container my-5 text-center">
                <div class="alert alert-warning p-4 rounded-4 shadow-sm">
                    <h5 class="fw-bold">⚠️ Tutorial no encontrado</h5>
                    <p class="mb-0 small">No existen contenidos cargados para la lección ID: <strong>${lessonId}</strong>.</p>
                    <a href="?id=9" class="btn btn-outline-primary btn-sm mt-3">Volver al Tutorial 9</a>
                </div>
            </div>`;
            return;
        }

        const formatBold = (text) => text ? text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') : '';

        const shuffledQuizOptions = data.quiz?.opciones 
            ? [...data.quiz.opciones].sort(() => Math.random() - 0.5) 
            : [];

        app.innerHTML = `
            <div class="container py-4" style="max-width: 1000px;">
                
                <style>
                    :root {
                        --ardunova-dark: #0b132b;
                        --ardunova-cyan: #06b6d4;
                        --ardunova-blue: #3b82f6;
                    }

                    .hero-ardunova {
                        background: linear-gradient(135deg, #0b132b 0%, #1c2541 60%, #1e1b4b 100%);
                        border: 1px solid rgba(6, 182, 212, 0.2);
                        box-shadow: 0 0 25px rgba(6, 182, 212, 0.15);
                    }

                    .card-glow {
                        background: #ffffff;
                        border: 1px solid #e2e8f0;
                        border-radius: 18px;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .card-glow:hover {
                        transform: translateY(-4px);
                        border-color: var(--ardunova-cyan);
                        box-shadow: 0 12px 30px -10px rgba(6, 182, 212, 0.25) !important;
                    }

                    .btn-details-custom {
                        background: #f8fafc;
                        border: 1px solid #e2e8f0;
                        color: #0284c7;
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

                    .btn-details-custom:hover {
                        background: #f0f9ff;
                        border-color: #38bdf8;
                        color: #0369a1;
                    }

                    .btn-details-custom .chevron-icon {
                        transition: transform 0.3s ease;
                        font-size: 0.75rem;
                    }

                    .btn-details-custom[aria-expanded="true"] .chevron-icon {
                        transform: rotate(180deg);
                    }

                    .btn-details-custom[aria-expanded="true"] {
                        background: #fef9c3;
                        border-color: #ca8a04;
                    }

                    .details-box {
                        background: #f8fafc;
                        border-left: 4px solid #eab308;
                        border-radius: 8px;
                        padding: 12px 16px;
                        font-size: 0.88rem;
                        color: #334155;
                        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
                        animation: fadeInDetails 0.3s ease-in-out;
                    }

                    @keyframes fadeInDetails {
                        from { opacity: 0; transform: translateY(-6px); }
                        to { opacity: 1; transform: translateY(0); }
                    }

                    .code-glow {
                        background: #090d16;
                        border: 1px solid rgba(59, 130, 246, 0.3);
                        box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5);
                    }

                    .btn-ardunova {
                        background: linear-gradient(135deg, #0284c7, #2563eb);
                        color: white;
                        border: none;
                        font-weight: 600;
                        border-radius: 12px;
                        transition: all 0.2s ease;
                        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
                    }

                    .btn-ardunova:hover:not(:disabled) {
                        background: linear-gradient(135deg, #0369a1, #1d4ed8);
                        color: white;
                        transform: translateY(-1px);
                        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
                    }

                    .btn-ardunova:disabled {
                        background: #94a3b8;
                        cursor: not-allowed;
                        box-shadow: none;
                        opacity: 0.6;
                    }

                    .quiz-btn-interactive {
                        transition: all 0.25s ease;
                        border: 2px solid #e2e8f0;
                        background-color: #f8fafc;
                        border-radius: 12px;
                        font-weight: 500;
                    }

                    .quiz-btn-interactive:hover {
                        border-color: #eab308;
                        background-color: #fefce8;
                        transform: translateX(4px);
                    }

                    .pulse-badge {
                        animation: pulseGlow 2s infinite;
                    }

                    @keyframes pulseGlow {
                        0% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.4); }
                        70% { box-shadow: 0 0 0 10px rgba(234, 179, 8, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
                    }
                </style>

                <!-- Hero Cabecera -->
                <header class="hero-ardunova rounded-4 p-4 p-md-5 mb-5 text-white position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge px-3 py-2 rounded-pill bg-warning text-dark font-monospace pulse-badge" style="font-size: 0.8rem;">
                                ${data.badge || 'INTERMEDIO'}
                            </span>
                        </div>
                        <h1 class="fw-bold display-6 text-white mb-2">${data.titulo}</h1>
                        <p class="fs-6 text-light opacity-75 mb-0">${data.subtitulo}</p>
                    </div>
                </header>

                <!-- Concepto Principal -->
                ${data.concepto_principal ? `
                <section class="card card-glow shadow-sm mb-4 p-4" style="border-left: 6px solid #eab308 !important;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 fs-3">🟡</div>
                        <div>
                            <h2 class="h5 fw-bold text-dark mb-2">${data.concepto_principal.titulo}</h2>
                            <p class="text-secondary mb-0 leading-relaxed" style="font-size: 0.95rem;">
                                ${formatBold(data.concepto_principal.descripcion)}
                            </p>
                        </div>
                    </div>
                </section>
                ` : ''}

                <!-- Funciones y Detalles Clave -->
                ${data.funciones_clave && data.funciones_clave.length > 0 ? `
                <h3 class="h5 fw-bold text-dark mb-3">Especificaciones y Funciones Clave</h3>
                <div class="row g-3 mb-5">
                    ${data.funciones_clave.map((item, index) => `
                        <div class="col-md-6">
                            <div class="card card-glow h-100 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <span class="fs-3 p-2 bg-warning bg-opacity-10 rounded-3 text-warning">${item.icono || '⚡'}</span>
                                        <div>
                                            <h4 class="h6 fw-bold mb-0 text-dark font-monospace" style="font-size: 1.1rem;">${item.titulo}</h4>
                                        </div>
                                    </div>
                                    <p class="text-secondary small mb-2 mt-2">${item.descripcion}</p>
                                </div>
                                
                                ${item.detalle ? `
                                <div>
                                    <button class="btn-details-custom" type="button" data-bs-target="#collapseDetalle_${index}" aria-expanded="false">
                                        <span>ℹ️ Ver detalles técnicos</span>
                                        <span class="chevron-icon">▼</span>
                                    </button>
                                    <div class="collapse mt-2" id="collapseDetalle_${index}">
                                        <div class="details-box">
                                            ${formatBold(item.detalle)}
                                        </div>
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    `).join('')}
                </div>
                ` : ''}

                <!-- Bloque de Código -->
                ${data.codigo_ejemplo ? `
                <section class="card code-glow rounded-4 mb-5 overflow-hidden shadow-lg">
                    <div class="card-header bg-black bg-opacity-50 border-bottom border-secondary border-opacity-25 py-3 px-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle bg-danger d-inline-block" style="width: 10px; height: 10px;"></span>
                            <span class="rounded-circle bg-warning d-inline-block" style="width: 10px; height: 10px;"></span>
                            <span class="rounded-circle bg-success d-inline-block" style="width: 10px; height: 10px;"></span>
                            <span class="font-monospace small text-info ms-2">${data.codigo_ejemplo.titulo}</span>
                        </div>
                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-25 font-monospace">
                            ${data.codigo_ejemplo.lenguaje}
                        </span>
                    </div>
                    <div class="card-body p-4 font-monospace" style="font-size: 0.9rem; color: #e2e8f0; overflow-x: auto;">
                        <pre class="m-0"><code>${data.codigo_ejemplo.codigo}</code></pre>
                    </div>
                </section>
                ` : ''}

                <!-- Simulador Wokwi Integrado -->
                ${data.simulador_wokwi ? `
                <section class="card card-glow shadow-sm mb-5 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                        <h3 class="h6 fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span>🎮</span> ${data.simulador_wokwi.titulo}
                        </h3>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">● En Vivo</span>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-50">
                        <p class="small text-muted mb-3">${formatBold(data.simulador_wokwi.instruccion)}</p>
                        
                        <div class="ratio ratio-16x9 rounded-4 border border-2 border-warning shadow-sm bg-white overflow-hidden mb-3" style="max-height: 460px;">
                            <iframe 
                                src="https://wokwi.com/projects/${data.simulador_wokwi.project_id}?embed=1" 
                                title="Simulador Wokwi Arduino"
                                allow="autoplay">
                            </iframe>
                        </div>

                        ${data.simulador_wokwi.nota ? `
                        <div class="p-3 bg-white border rounded-3 text-secondary small shadow-sm">
                            ${formatBold(data.simulador_wokwi.nota)}
                        </div>
                        ` : ''}
                    </div>
                </section>
                ` : ''}

                <!-- Quiz Interactivo -->
                ${data.quiz ? `
                <section class="card card-glow shadow-sm p-4 mb-5" style="border-top: 5px solid #eab308 !important;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge px-3 py-2 rounded-pill font-monospace" style="background-color: #fef9c3; color: #854d0e;">
                            🧠 RETO DE CONOCIMIENTO
                        </span>
                    </div>
                    <p class="fw-bold text-dark mb-3" style="font-size: 1rem;">${data.quiz.pregunta}</p>

                    <div class="d-flex flex-column gap-2 mb-3">
                        ${shuffledQuizOptions.map(opt => `
                            <button class="btn text-start p-3 quiz-btn-interactive" 
                                    style="font-size: 0.9rem;"
                                    data-correct="${opt.es_correcta}">
                                ${opt.texto}
                            </button>
                        `).join('')}
                    </div>
                    <div id="quiz-feedback" class="small fw-bold mt-2"></div>
                </section>
                ` : ''}

                <!-- Paginación y Navegación -->
                <footer class="d-flex justify-content-between align-items-center pt-4 border-top">
                    <button id="btn-prev" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold" style="font-size: 0.9rem;">
                        ← Lección Anterior
                    </button>
                    <span class="text-muted font-monospace small">Lección ${lessonId} de 16</span>
                    <button id="btn-next" class="btn btn-ardunova px-4 py-2" style="font-size: 0.9rem;" ${data.quiz ? 'disabled' : ''}>
                        Siguiente Lección →
                    </button>
                </footer>

            </div>
        `;

        // MANEJADOR DE EVENTO NATIVO: Desplegar detalles técnicos
        document.querySelectorAll('.btn-details-custom').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-bs-target');
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', !isExpanded);
                    
                    if (isExpanded) {
                        targetEl.classList.remove('show');
                        targetEl.style.display = 'none';
                    } else {
                        targetEl.classList.add('show');
                        targetEl.style.display = 'block';
                    }
                }
            });
        });

        // Estado local para verificar si el quiz fue aprobado
        let isQuizPassed = false;

        // Navegación (Siguiente / Anterior)
        const currentNum = parseInt(lessonId, 10);
        const btnNext = document.getElementById('btn-next');
        const btnPrev = document.getElementById('btn-prev');

        if (btnPrev) {
            if (currentNum <= 9) btnPrev.classList.add('disabled');
            btnPrev.addEventListener('click', () => {
                if (currentNum > 9) {
                    window.location.search = `?id=${currentNum - 1}`;
                }
            });
        }

        if (btnNext) {
            if (currentNum >= 16) {
                btnNext.classList.add('disabled');
            } else {
                btnNext.addEventListener('click', (e) => {
                    if (data.quiz && !isQuizPassed) {
                        e.preventDefault();
                        e.stopPropagation();
                        alert('⚠️ Debes responder correctamente la pregunta del quiz para avanzar al siguiente tutorial.');
                        return false;
                    }

                    // Petición AJAX para guardar el progreso en el archivo central de la raíz
                    fetch('../guardar_progreso.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_tutorial=${currentNum}`
                    })
                    .then(response => response.json())
                    .then(dataResponse => {
                        if (!dataResponse.ok) {
                            console.error('Error al guardar el progreso:', dataResponse.mensaje);
                        }
                    })
                    .catch(error => console.error('Error en la petición:', error));

                    window.location.search = `?id=${currentNum + 1}`;
                });
            }
        }

        // Eventos para las Opciones del Quiz
        const quizBtns = document.querySelectorAll('.quiz-btn-interactive');
        const feedback = document.getElementById('quiz-feedback');
        
        if (quizBtns.length > 0 && feedback && data.quiz) {
            quizBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    quizBtns.forEach(b => {
                        b.style.backgroundColor = "#f8fafc";
                        b.style.borderColor = "#e2e8f0";
                        b.style.color = "#212529";
                    });
                    
                    if (btn.dataset.correct === "true") {
                        isQuizPassed = true;
                        btn.style.backgroundColor = "#dcfce7";
                        btn.style.borderColor = "#22c55e";
                        btn.style.color = "#15803d";
                        feedback.className = "small fw-bold mt-2 text-success";
                        feedback.textContent = data.quiz.mensaje_correcto + " ¡Ya podés avanzar a la siguiente lección!";
                        
                        if (btnNext) {
                            btnNext.disabled = false;
                        }
                    } else {
                        isQuizPassed = false;
                        btn.style.backgroundColor = "#fee2e2";
                        btn.style.borderColor = "#ef4444";
                        btn.style.color = "#b91c1c";
                        feedback.className = "small fw-bold mt-2 text-danger";
                        feedback.textContent = data.quiz.mensaje_incorrecto + " Respondé correctamente para desbloquear la siguiente lección.";
                        
                        if (btnNext) {
                            btnNext.disabled = true;
                        }
                    }
                });
            });
        }

    } catch (error) {
        app.innerHTML = `
            <div class="container my-5 text-center">
                <div class="alert alert-danger p-4 rounded-4 shadow-sm">
                    <h5 class="fw-bold text-danger">⚠️ Error al cargar el tutorial</h5>
                    <p class="mb-0 font-monospace small text-secondary">${error.message}</p>
                </div>
            </div>`;
    }
}