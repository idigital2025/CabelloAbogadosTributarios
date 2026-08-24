<?php
/**
 * Template Name: Reforma Tributaria
 * Template para la landing page de asesoría por Reforma Tributaria
 *
 * @package CabelloAbogados
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Si la página está protegida con contraseña en WordPress
if ( post_password_required() ) :
?>
    <style>
        #main-header {
            background-color: #212C44 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
    </style>
    <main class="pt-36 pb-24 bg-gray-50 min-h-[75vh] flex items-center justify-center">
        <div class="container mx-auto px-6">
            <div class="max-w-md mx-auto bg-white p-8 md:p-10 rounded-xl shadow-2xl border-t-4 border-custom-gold text-center fade-in-up">
                <div class="w-16 h-16 bg-custom-gold/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-lock text-3xl text-custom-gold"></i>
                </div>
                <h1 class="text-2xl font-normal text-custom-blue mb-3">Contenido Protegido</h1>
                <p class="text-custom-dark-gray text-base font-light mb-6 leading-relaxed">
                    Esta página requiere contraseña para acceder. Por favor, ingrese la clave a continuación.
                </p>
                <div class="password-form-wrapper">
                    <?php echo get_the_password_form(); ?>
                </div>
            </div>
        </div>
    </main>
<?php
    get_footer();
    return;
endif;
?>

<main class="landing-reforma-tributaria">

    <!-- 1. HEADER / HERO SECTION -->
    <!--
        TODO (cliente): textos definitivos del encabezado (badge, H1, bajada) pendientes.
        Se mantiene el copy actual como placeholder mientras tanto.

        ESPACIADO BAJO EL HEADER: #main-header es "fixed" (se monta encima del contenido, no lo
        empuja). En el home del mismo sitio, el banner principal usa pt-0 md:pt-[220px] para
        separarse del header fijo en desktop. Replicamos ese mismo valor acá para que quede
        consistente con el resto del sitio.

        VIDEO DE FONDO (pedido de Jorge): dos variantes listas para activar (desktop / mobile),
        ocultas vía clases hidden/md:block igual que el resto del sitio. Cada variante trae
        WebM primero (más liviano, lo usa la mayoría de navegadores) y MP4 como fallback
        (compatibilidad total con Safari/iOS) — el navegador usa la primera <source> que soporte.

        Para activar: cambiar el "if (false)" de abajo por "if (true)" y reemplazar el src de
        cada <source> por el archivo definitivo. Se necesitan 4 archivos en total (2 por variante):
        (Nota técnica: se usa if(false)/endif en vez de un comentario /* */ porque un comentario
        PHP que contiene <?php ?> anidados corta el comentario antes de tiempo y filtra HTML a
        la página — if(false) es la forma segura de dejar HTML+PHP mezclado inerte.)
          - Formato: WebM (VP9) + MP4 (H.264) del mismo video, sin audio, loop de 10-15s.
          - Desktop: 1920x1080 (16:9). WebM apuntar a ~2-4MB, MP4 fallback ~4-6MB.
          - Mobile: 1080x1350 (formato más vertical, 4:5) o el mismo 16:9 recortado.
            WebM apuntar a ~1-2MB, MP4 fallback ~2-3MB (el móvil no debería cargar el
            archivo pesado de desktop: por eso son variantes/nombres de archivo separados).
          - Herramienta simple: HandBrake para el MP4 (preset "Fast 1080p30", CRF ~28-30);
            para WebM, HandBrake también soporta el encoder VP9, o usar ffmpeg
            (ej: ffmpeg -i input.mp4 -c:v libvpx-vp9 -crf 32 -b:v 0 -an output.webm).
        Mientras no haya video, la imagen de fondo (servicio-reorganizacion.webp) sigue funcionando
        como fallback normal.
    -->
    <style>
        .hero-reforma { position: relative; overflow: hidden; }
        .hero-reforma .hero-content { padding-top: 0; }
        @media (min-width: 768px) {
            /* !important: Tailwind (via CDN) inyecta sus utilidades (.items-center) de forma
               asíncrona y puede terminar cargando después de este bloque, empatando en
               especificidad con .hero-reforma y ganando por orden de carga. Forzamos el
               resultado para no depender de ese orden. */
            .hero-reforma { align-items: flex-start !important; }
            .hero-reforma .hero-content { padding-top: 220px !important; }
        }
        .hero-reforma .hero-video {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; z-index: 0;
        }
        .hero-reforma .hero-badge {
            background: linear-gradient(135deg, #D4B483 0%, #BB9D73 100%);
            box-shadow: 0 4px 14px rgba(187, 157, 115, 0.45);
        }
        /* Jerarquía de botones: primario sólido y llamativo, secundario más discreto (outline).
           Alcance limitado a .hero-reforma para no afectar los botones .btn-primary/.btn-white
           del resto del sitio. */
        .hero-reforma .btn-primary {
            background-color: #BB9D73;
            color: #FFFFFF;
            border: 1px solid #BB9D73;
            box-shadow: 0 6px 20px rgba(187, 157, 115, 0.45);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
        }
        .hero-reforma .btn-primary:hover {
            background-color: #a5885f;
            border-color: #a5885f;
            color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(187, 157, 115, 0.6);
        }
        .hero-reforma .btn-white {
            background-color: transparent;
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: transform 0.25s ease, background-color 0.25s ease, border-color 0.25s ease;
        }
        .hero-reforma .btn-white:hover {
            background-color: rgba(255, 255, 255, 0.12);
            border-color: #FFFFFF;
            color: #FFFFFF;
            transform: translateY(-2px);
        }
        /* Indicador de scroll */
        .hero-reforma .scroll-indicator {
            position: absolute;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            text-decoration: none;
            animation: hero-scroll-bounce 2s ease-in-out infinite;
            transition: border-color 0.25s ease, background-color 0.25s ease;
        }
        .hero-reforma .scroll-indicator:hover {
            border-color: #BB9D73;
            background-color: rgba(187, 157, 115, 0.15);
        }
        @keyframes hero-scroll-bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(8px); }
        }
    </style>
    <section class="hero-reforma h-[75vh] min-h-[500px] text-white relative bg-cover bg-center flex items-center"
             style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/servicio-reorganizacion.webp');">

        <?php if (false): // cambiar a "if (true)" cuando estén los 4 archivos de video listos ?>
        <video class="hero-video hidden md:block" autoplay muted loop playsinline
               poster="<?php echo get_template_directory_uri(); ?>/assets/img/servicio-reorganizacion.webp">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-reforma-tributaria-desktop.webm" type="video/webm">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-reforma-tributaria-desktop.mp4" type="video/mp4">
        </video>
        <video class="hero-video block md:hidden" autoplay muted loop playsinline
               poster="<?php echo get_template_directory_uri(); ?>/assets/img/servicio-reorganizacion.webp">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-reforma-tributaria-mobile.webm" type="video/webm">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-reforma-tributaria-mobile.mp4" type="video/mp4">
        </video>
        <?php endif; ?>

        <div class="absolute inset-0 bg-custom-blue opacity-75 z-[1]"></div>
        <div class="hero-content container mx-auto px-6 relative z-10 text-center md:text-left">
            <div class="max-w-4xl">
                <span class="hero-badge inline-block text-white text-xs md:text-sm uppercase tracking-widest font-semibold px-4 py-1.5 rounded mb-4 fade-in-up">
                    Análisis &amp; Estrategia Legal - Reforma Tributaria
                </span>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-normal leading-tight mb-6 fade-in-up text-white" style="transition-delay: 0.1s;">
                    Asesoría Estratégica ante la Nueva Reforma Tributaria
                </h1>
                <p class="text-base md:text-xl font-light leading-relaxed max-w-3xl mb-8 opacity-95 fade-in-up text-white" style="transition-delay: 0.2s;">
                    Acompañamos a <b>empresas, holdings e inversionistas</b> en la evaluación de impactos, reorganización de estructuras y mitigación de riesgos legales y patrimoniales tras las recientes reformas y normas de cumplimiento tributario en Chile.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 fade-in-up" style="transition-delay: 0.3s;">
                    <a href="#formulario-reforma" class="btn btn-primary text-center font-semibold">
                        Agendar Reunión Comercial
                    </a>
                    <a href="#materias-aprobadas" class="btn btn-white text-center font-semibold">
                        Ver Materias Clave ↓
                    </a>
                </div>
            </div>
        </div>

        <a href="#materias-aprobadas" class="scroll-indicator" aria-label="Bajar para ver más contenido">
            <i class="fas fa-chevron-down text-sm"></i>
        </a>
    </section>

    <!-- BANNER DE ALERTA ESTRATÉGICA -->
    <section class="bg-custom-gold text-white py-6">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
            <div class="flex items-center space-x-3">
                <i class="fas fa-exclamation-circle text-2xl text-custom-blue flex-shrink-0"></i>
                <p class="text-base font-medium text-custom-blue">
                    <b>Atención Holdings e Inversionistas:</b> Los plazos legales para acogerse a regímenes sustitutivos transitorios y ajustar estructuras societarias ya se encuentran vigentes.
                </p>
            </div>
            <a href="#formulario-reforma" class="px-5 py-2.5 bg-custom-blue text-white rounded text-xs md:text-sm font-semibold hover:bg-opacity-90 transition-all flex-shrink-0">
                Evaluar mi Caso
            </a>
        </div>
    </section>

    <!-- 2. PRINCIPALES MATERIAS EN DISCUSIÓN / APROBADAS -->
    <section id="materias-aprobadas" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16 fade-in-up">
                <!-- TODO (cliente): título nuevo pendiente (se eliminó "Nuevas Reglas del Juego Fiscal"). Subtítulo y bajada dorada eliminados por pedido del cliente, no se repone. -->
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Materia 1 -->
                <div class="service-card bg-gray-50 p-8 rounded-lg border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 fade-in-up">
                    <h3 class="text-xl font-semibold text-custom-blue mb-3">Impuesto Corporativo y Regímenes</h3>
                    <p class="text-custom-dark-gray text-base font-light leading-relaxed mb-4">
                        Modificaciones en el impuesto de Primera Categoría, incentivos al ahorro e inversión corporativa, y ajustes en la tributación de utilidades empresariales.
                    </p>
                </div>

                <!-- Materia 2 -->
                <div class="service-card bg-gray-50 p-8 rounded-lg border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 fade-in-up" style="transition-delay: 0.1s;">
                    <h3 class="text-xl font-semibold text-custom-blue mb-3">Impuesto Sustitutivo (ISIF)</h3>
                    <p class="text-custom-dark-gray text-base font-light leading-relaxed mb-4">
                        Régimen opcional para tributar utilidades acumuladas en los registros tributarios (FUT/RAP) a una tasa fija y preferencial con liberación de tributación futura.
                    </p>
                </div>

                <!-- Materia 3 -->
                <div class="service-card bg-gray-50 p-8 rounded-lg border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 fade-in-up" style="transition-delay: 0.2s;">
                    <h3 class="text-xl font-semibold text-custom-blue mb-3">Repatriación de Capitales</h3>
                    <p class="text-custom-dark-gray text-base font-light leading-relaxed mb-4">
                        Mecanismos extraordinarios de declaración voluntaria e impuesto único liberatorio para bienes, fondos y divisas mantenidos fuera de Chile por contribuyentes locales.
                    </p>
                </div>

                <!-- Materia 4 -->
                <div class="service-card bg-gray-50 p-8 rounded-lg border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 fade-in-up" style="transition-delay: 0.3s;">
                    <h3 class="text-xl font-semibold text-custom-blue mb-3">Normas Antielusión (NGA / GAAR)</h3>
                    <p class="text-custom-dark-gray text-base font-light leading-relaxed mb-4">
                        Nuevos criterios de aplicación de la Norma General Antielusiva, fiscalizaciones del SII a reorganizaciones y fiscalización de grupos empresariales.
                    </p>
                </div>

                <!-- Materia 5 -->
                <div class="service-card bg-gray-50 p-8 rounded-lg border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 fade-in-up" style="transition-delay: 0.4s;">
                    <h3 class="text-xl font-semibold text-custom-blue mb-3">Certeza e Invariabilidad Tributaria</h3>
                    <p class="text-custom-dark-gray text-base font-light leading-relaxed mb-4">
                        Protección legal e incentivos tributarios para proyectos de inversión de alto impacto y contratos de estabilidad para capitales internacionales.
                    </p>
                </div>

                <!-- Materia 6 -->
                <div class="service-card bg-gray-50 p-8 rounded-lg border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 fade-in-up" style="transition-delay: 0.5s;">
                    <h3 class="text-xl font-semibold text-custom-blue mb-3">Franquicias de Donaciones</h3>
                    <p class="text-custom-dark-gray text-base font-light leading-relaxed mb-4">
                        Actualización del marco regulatorio sobre beneficios tributarios por donaciones corporativas y financiamiento a proyectos de interés social.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. IMPACTO POTENCIAL PARA EMPRESAS -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in-up">
                    <h2 class="section-title mb-2">Impacto en la Toma de Decisiones Corporativas</h2>
                    <h3 class="section-subtitle mb-6">¿Cómo afecta la Reforma Tributaria a su Empresa?</h3>
                    <p class="text-custom-dark-gray font-light text-base leading-relaxed mb-6">
                        Las nuevas normativas imponen un replanteamiento de la planificación financiera, corporativa y tributaria. Estructuras constituidas en esquemas anteriores requieren revisión para mantener su coherencia económica y prevenir observaciones de la autoridad fiscal.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-custom-gold/20 flex items-center justify-center mr-4 flex-shrink-0 mt-1">
                                <i class="fas fa-chart-line text-custom-gold text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-custom-blue text-base">Carga Fiscal y Flujos de Caja</h4>
                                <p class="text-custom-dark-gray text-base font-light leading-relaxed">Determinación rigurosa de la tasa efectiva final de impuestos corporativos y estructuración de repartos de dividendos.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-custom-gold/20 flex items-center justify-center mr-4 flex-shrink-0 mt-1">
                                <i class="fas fa-sitemap text-custom-gold text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-custom-blue text-base">Reorganización de Holdings y Filiales</h4>
                                <p class="text-custom-dark-gray text-base font-light leading-relaxed">Adaptación de mallas societarias asegurando la legítima razón de negocios y el respaldo sustantivo de las operaciones de grupo.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-custom-gold/20 flex items-center justify-center mr-4 flex-shrink-0 mt-1">
                                <i class="fas fa-user-shield text-custom-gold text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-custom-blue text-base">Gobernanza y Cumplimiento Preventivo</h4>
                                <p class="text-custom-dark-gray text-base font-light leading-relaxed">Respaldos técnicos para directorios y gerencias frente a procesos de fiscalización y requerimientos del Servicio de Impuestos Internos.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fade-in-up" style="transition-delay: 0.2s;">
                    <div class="relative rounded-lg overflow-hidden shadow-2xl">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/enfoque-imagen.webp"
                             alt="Reunión directiva analizando impacto tributario empresarial"
                             class="w-full h-auto object-cover">
                        <div class="absolute inset-0 gradient-overlay-bottom" style="background: linear-gradient(to top, rgba(33, 44, 68, 0.98) 0%, rgba(33, 44, 68, 0.8) 55%, rgba(33, 44, 68, 0) 100%);"></div>
                        <div class="absolute bottom-0 inset-x-0 p-6 md:p-8 text-white z-10">
                            <p class="text-xs md:text-sm font-semibold text-custom-gold uppercase tracking-wider mb-1">Asesoría Corporativa</p>
                            <p class="text-base font-light text-white leading-relaxed">Definición de hojas de ruta legales para directorios y gerencias de finanzas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--
        Secciones eliminadas por pedido del cliente:
        - "Efectos Patrimoniales y de Inversión" (bloque + foto servicio-asesoria.webp): se fusionó
          con la sección anterior ("Impacto en la Toma de Decisiones Corporativas"), que ahora queda
          como el único bloque de imagen+texto y conserva la foto de la escalera (enfoque-imagen.webp).
          TODO (cliente): texto consolidado pendiente para ese bloque unificado.
        - "Soluciones Específicas Priorizadas" (4 tarjetas de áreas): eliminada completa.
        - "Experiencia del Estudio en Cifras" / "Por qué Cabello Abogados" (contadores): eliminada completa.
    -->

    <!-- 7. VOCEROS Y ABOGADOS EXPERTOS -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in-up">
                <!-- TODO (cliente): pulir texto del título de esta sección -->
                <h2 class="section-title">Nuestros Voceros y Abogados Expertos</h2>
                <h3 class="section-subtitle">Líderes de opinión y referentes en materias tributarias</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 items-start">

                <!-- Vocero 1: Juan Pablo Cabello -->
                <div class="bg-white rounded-lg p-6 fade-in-up shadow-lg">
                    <img src="https://cabelloabogados.cl/wp-content/uploads/2026/02/juan-pablo_resultado7.webp"
                         alt="Foto de Juan Pablo Cabello P."
                         class="w-full rounded-md mb-4 aspect-[3/4] object-cover">
                    <h3 class="text-xl font-semibold text-custom-blue">Juan Pablo Cabello P.</h3>
                    <p class="text-custom-gold mb-2 text-sm font-medium">Socio Fundador</p>
                    <a href="mailto:juan.cabello@cabelloabogados.cl" class="text-xs text-custom-dark-gray hover:text-custom-gold transition-colors flex items-center mb-4 truncate">
                        <i class="fas fa-envelope mr-2 text-custom-gold flex-shrink-0"></i>
                        <span class="truncate">juan.cabello@cabelloabogados.cl</span>
                    </a>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <button class="accordion-toggle w-full text-left font-semibold flex justify-between items-center text-custom-blue text-sm">
                            Ver Trayectoria <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="accordion-content text-sm text-custom-dark-gray font-light">
                            <p class="mt-2 mb-2 leading-relaxed">
                                Abogado (Universidad de Chile), Magíster en Dirección y Gestión Tributaria (UAI). Vicepresidente del Instituto Chileno de Derecho Tributario (ICDT). Reconocido por Chambers &amp; Partners, Legal 500 y Best Lawyers.
                            </p>
                            <p class="leading-relaxed">
                                Profesor en Magísteres de Tributación en la P. Universidad Católica de Chile y Universidad de Chile.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Vocero 2: María Pilar Cabello -->
                <div class="bg-white rounded-lg p-6 fade-in-up shadow-lg" style="transition-delay: 0.1s;">
                    <img src="https://cabelloabogados.cl/wp-content/uploads/2026/02/pilar_resultado11.webp"
                         alt="Foto de María Pilar Cabello P."
                         class="w-full rounded-md mb-4 aspect-[3/4] object-cover">
                    <h3 class="text-xl font-semibold text-custom-blue">María Pilar Cabello P.</h3>
                    <p class="text-custom-gold mb-2 text-sm font-medium">Socia Auditoría &amp; Peritaje</p>
                    <a href="mailto:pilar.cabello@cabelloabogados.cl" class="text-xs text-custom-dark-gray hover:text-custom-gold transition-colors flex items-center mb-4 truncate">
                        <i class="fas fa-envelope mr-2 text-custom-gold flex-shrink-0"></i>
                        <span class="truncate">pilar.cabello@cabelloabogados.cl</span>
                    </a>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <button class="accordion-toggle w-full text-left font-semibold flex justify-between items-center text-custom-blue text-sm">
                            Ver Trayectoria <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="accordion-content text-sm text-custom-dark-gray font-light">
                            <p class="mt-2 mb-2 leading-relaxed">
                                Contador Público y Auditor (USACH), Magíster en Gestión Tributaria (UAI). Perito Judicial acreditada en Cortes de Apelaciones.
                            </p>
                            <p class="leading-relaxed">
                                Ex Ejecutiva y Gerenta en Walmart Chile y D&amp;S. Docente en Diplomados de la Facultad de Economía y Negocios de la Universidad de Chile.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Vocero 3: Estephania Aguayo -->
                <div class="bg-white rounded-lg p-6 fade-in-up shadow-lg" style="transition-delay: 0.2s;">
                    <img src="https://cabelloabogados.cl/wp-content/uploads/2026/06/estephania-2.webp"
                         alt="Foto de Estephania Aguayo A."
                         class="w-full rounded-md mb-4 aspect-[3/4] object-cover">
                    <h3 class="text-xl font-semibold text-custom-blue">Estephania Aguayo A.</h3>
                    <p class="text-custom-gold mb-2 text-sm font-medium">Socia Consultoría &amp; Reorganización</p>
                    <a href="mailto:estephania.aguayo@cabelloabogados.cl" class="text-xs text-custom-dark-gray hover:text-custom-gold transition-colors flex items-center mb-4 truncate">
                        <i class="fas fa-envelope mr-2 text-custom-gold flex-shrink-0"></i>
                        <span class="truncate">estephania.aguayo@cabelloabogados.cl</span>
                    </a>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <button class="accordion-toggle w-full text-left font-semibold flex justify-between items-center text-custom-blue text-sm">
                            Ver Trayectoria <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="accordion-content text-sm text-custom-dark-gray font-light">
                            <p class="mt-2 mb-2 leading-relaxed">
                                Abogada (Universidad de Chile), Magíster en Dirección y Gestión Tributaria (UAI). Especialista en estructuras corporativas complejas.
                            </p>
                            <p class="leading-relaxed">
                                Docente del Diplomado en Planificación Tributaria en FEN U. de Chile.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Vocero 4: Michel Alejandro Aguilera -->
                <div class="bg-white rounded-lg p-6 fade-in-up shadow-lg" style="transition-delay: 0.3s;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Michel-Aguilera.webp"
                         alt="Foto de Michel Aguilera R."
                         class="w-full rounded-md mb-4 aspect-[3/4] object-cover">
                    <h3 class="text-xl font-semibold text-custom-blue">Michel Aguilera R.</h3>
                    <p class="text-custom-gold mb-2 text-sm font-medium">Socio Litigios Tributarios</p>
                    <a href="mailto:michel.aguilera@cabelloabogados.cl" class="text-xs text-custom-dark-gray hover:text-custom-gold transition-colors flex items-center mb-4 truncate">
                        <i class="fas fa-envelope mr-2 text-custom-gold flex-shrink-0"></i>
                        <span class="truncate">michel.aguilera@cabelloabogados.cl</span>
                    </a>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <button class="accordion-toggle w-full text-left font-semibold flex justify-between items-center text-custom-blue text-sm">
                            Ver Trayectoria <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="accordion-content text-sm text-custom-dark-gray font-light">
                            <p class="mt-2 mb-2 leading-relaxed">
                                Abogado (Universidad de Chile, Distinción Máxima), Magíster (c) en Derecho Tributario (U. de Chile). Ex Asociado Senior en firmas internacionales Dentons.
                            </p>
                            <p class="leading-relaxed">
                                Especialista en defensa forense procesal ante Tribunales Tributarios y Aduaneros (TTA).
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Botón Conocer a todo el equipo -->
            <div class="text-center mt-12 fade-in-up">
                <a href="<?php echo esc_url(home_url('/quienes-somos')); ?>" class="btn btn-primary font-semibold">
                    Conocer a todo el equipo →
                </a>
            </div>
        </div>
    </section>

    <!-- 8. AUTORIDAD Y PRENSA -->
    <section class="py-16 bg-white border-t border-b border-gray-100">
        <div class="container mx-auto px-6 text-center fade-in-up">
            <h2 class="section-title mb-2">Presencia en Medios y Respaldos Institucionales</h2>
            <h3 class="section-subtitle mb-8">Nuestros abogados analizan de forma continua la coyuntura tributaria nacional</h3>

            <!-- Grid de respaldos -->
            <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 mb-12">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-colegio-abogados.svg"
                     alt="Colegio de Abogados de Chile"
                     class="h-20 w-auto grayscale opacity-75 hover:grayscale-0 hover:opacity-100 transition-all">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-icdt.svg"
                     alt="Instituto Chileno de Derecho Tributario"
                     class="h-20 w-auto grayscale opacity-75 hover:grayscale-0 hover:opacity-100 transition-all">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-ifa.svg"
                     alt="International Fiscal Association"
                     class="h-20 w-auto grayscale opacity-75 hover:grayscale-0 hover:opacity-100 transition-all">
            </div>

            <!-- Carrusel de reconocimientos -->
            <div class="logo-carousel-container overflow-hidden pt-4">
                <div class="scrolling-wrapper">
                    <?php for ($i = 0; $i < 2; $i++) : ?>
                        <div class="logo-item px-6"><img src="https://cabelloabogados.cl/wp-content/uploads/2026/04/logo1-38.webp" alt="Reconocimiento Chambers & Partners" class="mx-auto grayscale opacity-60 h-16"></div>
                        <div class="logo-item px-6"><img src="https://cabelloabogados.cl/wp-content/uploads/2026/04/logo2-23.webp" alt="Reconocimiento The Legal 500" class="mx-auto grayscale opacity-60 h-16"></div>
                        <div class="logo-item px-6"><img src="https://cabelloabogados.cl/wp-content/uploads/2026/04/logo3-22.webp" alt="Reconocimiento Best Lawyers" class="mx-auto grayscale opacity-60 h-16"></div>
                        <div class="logo-item px-6"><img src="https://cabelloabogados.cl/wp-content/uploads/2026/04/logo4-21.webp" alt="Reconocimiento International Tax Review" class="mx-auto grayscale opacity-60 h-16"></div>
                        <div class="logo-item px-6"><img src="https://cabelloabogados.cl/wp-content/uploads/2026/04/logo5-19.webp" alt="Reconocimiento Leaders League" class="mx-auto grayscale opacity-60 h-16"></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. PREGUNTAS FRECUENTES (FAQ) CON INFORMACIÓN FIDEDIGNA Y PRECISA -->
    <!-- TODO (cliente): preguntas y respuestas definitivas pendientes; se mantiene el set actual como placeholder -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="section-title">Preguntas Frecuentes</h2>
                <h3 class="section-subtitle">Respuestas fidedignas a las principales inquietudes tributarias</h3>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 fade-in-up">
                    <button class="accordion-toggle w-full text-left font-semibold text-lg text-custom-blue flex justify-between items-center">
                        <span>¿Cuándo entran en vigencia las principales disposiciones de la nueva reforma y leyes de cumplimiento tributario?</span>
                        <i class="fas fa-chevron-down text-custom-gold transition-transform"></i>
                    </button>
                    <div class="accordion-content text-base text-custom-dark-gray font-light leading-relaxed">
                        <p class="pt-4 text-base font-light leading-relaxed">
                            Las normas sobre cumplimiento tributario y fiscalización rigen conforme a lo dispuesto en la legislación promulgada: aquellas relativas a facultades administrativas de fiscalización y procedimientos generales aplican tras su publicación en el Diario Oficial, mientras que las reglas especiales de sustitución de impuestos y modificaciones a regímenes de impuesto a la renta operan bajo plazos y disposiciones transitorias expresas.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 fade-in-up" style="transition-delay: 0.1s;">
                    <button class="accordion-toggle w-full text-left font-semibold text-lg text-custom-blue flex justify-between items-center">
                        <span>¿Cómo afectan las reglas de la Norma General Antielusiva (NGA) a holdings y sociedades de inversión?</span>
                        <i class="fas fa-chevron-down text-custom-gold transition-transform"></i>
                    </button>
                    <div class="accordion-content text-base text-custom-dark-gray font-light leading-relaxed">
                        <p class="pt-4 text-base font-light leading-relaxed">
                            El Servicio de Impuestos Internos (SII) intensifica la revisión de reestructuraciones corporativas, fusiones y traspasos societarios. Para evitar contingencias por abuso o simulación tributaria, es indispensable que toda reorganización cuente con una legítima razón de negocios con sustento económico y operativo acreditable, más allá del mero ahorro fiscal.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 fade-in-up" style="transition-delay: 0.2s;">
                    <button class="accordion-toggle w-full text-left font-semibold text-lg text-custom-blue flex justify-between items-center">
                        <span>¿Qué ventajas otorga el Impuesto Sustitutivo (ISIF) sobre utilidades acumuladas y quiénes pueden acogerse?</span>
                        <i class="fas fa-chevron-down text-custom-gold transition-transform"></i>
                    </button>
                    <div class="accordion-content text-base text-custom-dark-gray font-light leading-relaxed">
                        <p class="pt-4 text-base font-light leading-relaxed">
                            El Impuesto Sustitutivo de Impuestos Finales (ISIF) es un régimen opcional y voluntario que permite a los contribuyentes adelantar la tributación sobre saldos de utilidades acumuladas en los registros tributarios (FUT / RAP) aplicando una tasa única fija. Al pagar el ISIF, los montos quedan liberados de los impuestos finales (Global Complementario o Adicional) al momento de su retiro o distribución.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 fade-in-up" style="transition-delay: 0.3s;">
                    <button class="accordion-toggle w-full text-left font-semibold text-lg text-custom-blue flex justify-between items-center">
                        <span>¿En qué consiste el procedimiento de repatriación y declaración voluntaria de bienes en el extranjero?</span>
                        <i class="fas fa-chevron-down text-custom-gold transition-transform"></i>
                    </button>
                    <div class="accordion-content text-base text-custom-dark-gray font-light leading-relaxed">
                        <p class="pt-4 text-base font-light leading-relaxed">
                            Constituye un mecanismo legal extraordinario que permite a contribuyentes domiciliados o residentes en Chile declarar bienes, divisas o activos mantenidos fuera del país sin haber tributado oportunamente. Al acogerse mediante el pago de una tasa de impuesto único, el contribuyente obtiene la regularización fiscal liberándolo de sanciones administrativas, reajustes o acciones penales tributarias.
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 fade-in-up" style="transition-delay: 0.4s;">
                    <button class="accordion-toggle w-full text-left font-semibold text-lg text-custom-blue flex justify-between items-center">
                        <span>¿Por qué es fundamental realizar una auditoría y planificación preventiva con un estudio tributario boutique?</span>
                        <i class="fas fa-chevron-down text-custom-gold transition-transform"></i>
                    </button>
                    <div class="accordion-content text-base text-custom-dark-gray font-light leading-relaxed">
                        <p class="pt-4 text-base font-light leading-relaxed">
                            Una revisión técnica oportuna dictaminada por abogados y contadores peritos tributarios permite identificar inconsistencias en los registros empresariales antes de una fiscalización formal del SII, cuantificar contingencias de manera exacta y aprovechar los beneficios o ventanas transitorias vigentes en la legislación chilena.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. FORMULARIO DE CONVERSIÓN (CTA FINAL) -->
    <section id="formulario-reforma" class="relative py-24 text-white">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/formulario-contacto-fondo.webp');"></div>
        <div class="absolute inset-0 bg-custom-blue opacity-90"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto">

                <div class="text-center mb-12 fade-in-up">
                    <span class="text-custom-gold text-xs font-semibold uppercase tracking-widest block mb-2">Agende una Sesión Comercial con un Socio</span>
                    <h2 class="text-3xl md:text-4xl font-normal text-white mb-4">¿Listo para adaptar su empresa o patrimonio a la Reforma Tributaria?</h2>
                    <p class="text-white opacity-90 text-base font-light max-w-2xl mx-auto leading-relaxed">
                        Complete el formulario estratégico a continuación y un socio de nuestro estudio evaluará su requerimiento para agendar una reunión ejecutiva personalizada.
                    </p>
                </div>

                <?php
                // Verificación de integración con Contact Form 7
                $form_id = get_theme_mod('cabelloabogados_form_reforma', '');

                if ($form_id && function_exists('wpcf7_contact_form')) :
                    $contact_form = wpcf7_contact_form($form_id);
                    if ($contact_form) :
                        ?>
                        <div class="fade-in-up contact-form-wrapper bg-white/5 p-8 rounded-xl border border-white/10 backdrop-blur-sm">
                            <?php echo do_shortcode('[contact-form-7 id="' . esc_attr($form_id) . '"]'); ?>
                        </div>
                    <?php
                    endif;
                else :
                    // Formulario HTML nativo estructurado
                    ?>
                    <form class="space-y-6 bg-white/5 p-8 md:p-10 rounded-xl border border-white/10 backdrop-blur-sm fade-in-up" method="post" action="">
                        <?php wp_nonce_field('cabelloabogados_reforma_form', 'reforma_nonce'); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipo de Contribuyente -->
                            <div>
                                <label for="client_type" class="form-label">Tipo de Cliente / Perfil</label>
                                <select id="client_type" name="client_type" class="form-input text-gray-900 bg-white" required>
                                    <option value="" disabled selected>Seleccione perfil...</option>
                                    <option value="Empresa / Holding Corporativo">Empresa / Holding Corporativo</option>
                                    <option value="Socio / Inversionista / Persona Natural">Socio / Inversionista / Persona Natural</option>
                                    <option value="Family Office / Administración Patrimonial">Family Office / Administración Patrimonial</option>
                                    <option value="Asesor Legal o Financiero">Asesor Legal o Financiero Externo</option>
                                </select>
                            </div>

                            <!-- Nombre o Razón Social -->
                            <div>
                                <label for="fullname" class="form-label">Nombre Completo / Razón Social</label>
                                <input type="text" id="fullname" name="fullname" placeholder="Ej: Juan Pérez / Inversiones SpA" class="form-input" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="form-label">Email Corporativo o Personal</label>
                                <input type="email" id="email" name="email" placeholder="nombre@empresa.cl" class="form-input" required>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="phone" class="form-label">Teléfono de Contacto Directo</label>
                                <input type="tel" id="phone" name="phone" placeholder="+56 9 1234 5678" class="form-input" required>
                            </div>
                        </div>

                        <!-- Campo "Plazo para Resolver" eliminado por pedido del cliente -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Materia de Consulta -->
                            <div>
                                <label for="subject_area" class="form-label">Materia Principal</label>
                                <select id="subject_area" name="subject_area" class="form-input text-gray-900 bg-white" required>
                                    <option value="" disabled selected>Seleccione materia...</option>
                                    <!-- TODO (cliente): ajuste exacto del texto de estas opciones pendiente -->
                                    <option value="Reorganización Corporativa / Holding">Reorganización Corporativa / Holding</option>
                                    <option value="Impuesto Sustitutivo ISIF">Impuesto Sustitutivo ISIF</option>
                                    <option value="Repatriación de Capitales">Repatriación de Capitales</option>
                                    <option value="Planificación Patrimonial Familiar">Planificación Patrimonial Familiar</option>
                                    <option value="Litigio / Defensa ante el SII">Litigio / Defensa ante el SII</option>
                                    <option value="Diagnóstico General Reforma">Diagnóstico General Reforma</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>

                            <!-- Medio preferido -->
                            <div>
                                <label for="preferred_medium" class="form-label">Canal Preferido</label>
                                <select id="preferred_medium" name="preferred_medium" class="form-input text-gray-900 bg-white" required>
                                    <option value="" disabled selected>Seleccione medio...</option>
                                    <option value="Reunión Presencial (Las Condes)">Reunión Presencial (Las Condes)</option>
                                    <option value="Videollamada (Teams / Zoom)">Videollamada (Teams / Zoom)</option>
                                    <option value="Llamada Telefónica">Llamada Telefónica</option>
                                    <option value="Respuesta por Email">Respuesta por Email</option>
                                </select>
                            </div>
                        </div>

                        <!-- Mensaje -->
                        <div>
                            <label for="message" class="form-label">Detalles o Comentarios Adicionales</label>
                            <textarea id="message" name="message" rows="4" placeholder="Describa brevemente la situación de su empresa o patrimonio..." class="form-input"></textarea>
                        </div>

                        <!-- Aceptación -->
                        <div class="flex items-start pt-2">
                            <input type="checkbox" id="privacy_reforma" name="privacy" class="mt-1 mr-3 rounded border-gray-600 bg-gray-700 focus:ring-custom-gold" required>
                            <label for="privacy_reforma" class="text-xs text-gray-300 font-light">
                                Acepto la <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="underline text-custom-gold hover:text-white">política de privacidad</a> y autorizo el tratamiento de los datos aportados para la programación de la reunión comercial.
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="submit" name="submit_reforma_contact" class="btn btn-primary w-full sm:w-auto text-base px-10 py-3 font-semibold shadow-lg hover:shadow-2xl">
                                Agendar Reunión Comercial con un Socio
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </section>

</main>

<?php
get_footer();
