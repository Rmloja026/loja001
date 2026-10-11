import os

css_path = r"c:\Users\studi\Downloads\mercado rm lja\@SERVIDOR\assets\css\black-theme.css"

premium_css = """

/* ============================================
   UI OVERHAUL PREMIUM v4 - ESTÉTICA PROFISSIONAL E INTUITIVA
   ============================================ */

/* 1. Animações de Entrada (Micro-interações) */
@keyframes fadeInUpScale {
    0% { opacity: 0; transform: translateY(15px) scale(0.98); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.card {
    animation: fadeInUpScale 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    background: linear-gradient(145deg, rgba(26, 32, 53, 0.9), rgba(15, 20, 35, 0.95)) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

/* Escalonamento de animação para os cards */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.15s; }
.card:nth-child(3) { animation-delay: 0.2s; }
.card:nth-child(4) { animation-delay: 0.25s; }
.card:nth-child(5) { animation-delay: 0.3s; }
.card:nth-child(6) { animation-delay: 0.35s; }

/* 2. Hover Premium nos Cards */
.card:hover {
    transform: translateY(-5px) scale(1.01) !important;
    border-color: rgba(99, 102, 241, 0.4) !important;
    box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.5), 0 0 20px rgba(99, 102, 241, 0.15) !important;
}

/* 3. Tabela - Linhas Interativas */
.table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: var(--border-radius-sm);
}

.table tbody tr:hover {
    background: rgba(99, 102, 241, 0.08) !important;
    transform: scale(1.01);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    z-index: 10;
    position: relative;
}

/* 4. Botões Premium */
.btn {
    border-radius: 50px !important; /* Estilo pílula moderno */
    font-weight: 700 !important;
    letter-spacing: 0.5px !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    padding: 10px 24px !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    border: 1px solid transparent;
}

.btn-outline-primary, .btn-outline-info, .btn-outline-success {
    background: rgba(255,255,255,0.02) !important;
    backdrop-filter: blur(5px);
}

.btn-outline-primary:hover { border-color: var(--accent-primary) !important; background: rgba(99, 102, 241, 0.15) !important; box-shadow: 0 0 15px rgba(99, 102, 241, 0.4) !important; }
.btn-outline-info:hover { border-color: var(--accent-cyan) !important; background: rgba(6, 182, 212, 0.15) !important; box-shadow: 0 0 15px rgba(6, 182, 212, 0.4) !important; }
.btn-outline-success:hover { border-color: var(--accent-emerald) !important; background: rgba(16, 185, 129, 0.15) !important; box-shadow: 0 0 15px rgba(16, 185, 129, 0.4) !important; }

/* 5. Inputs Modernizados */
.form-control, .input-group-outline .form-control, textarea.form-control {
    background: rgba(15, 20, 35, 0.6) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #e2e8f0 !important;
    border-radius: 8px !important;
    padding: 12px 16px !important;
}

.form-control:focus, .input-group-outline .form-control:focus {
    background: rgba(26, 32, 53, 0.9) !important;
    border-color: var(--accent-primary) !important;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2) !important;
    transform: translateY(-1px);
}

/* 6. Sidebar/Menu Lateral Aprimorado */
.sidenav {
    background: linear-gradient(180deg, #0f1423 0%, #0a0e1a 100%) !important;
    border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
    box-shadow: 5px 0 25px rgba(0,0,0,0.3);
}

.sidenav .nav-link {
    border-radius: 12px !important;
    margin: 4px 16px !important;
}

.sidenav .nav-link:hover {
    background: rgba(255, 255, 255, 0.08) !important;
    transform: translateX(5px) !important;
}

.sidenav .nav-link.active, .sidenav .nav-link.bg-blue-accent {
    background: linear-gradient(135deg, #6366f1, #4f46e5) !important;
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4) !important;
    border: none !important;
}

/* 7. Badges Elegantes */
.badge, .status-badge {
    border-radius: 6px !important;
    padding: 6px 12px !important;
    font-weight: 700 !important;
    letter-spacing: 0.5px !important;
    text-transform: uppercase;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* 8. Ajustes Responsivos e de Texto */
@media (max-width: 768px) {
    .card-header h6 { font-size: 1rem !important; }
    .kpi-card .kpi-value { font-size: 1.5rem !important; }
    .btn { padding: 8px 16px !important; font-size: 0.7rem !important; }
    
    /* Tabelas com rolagem horizontal fluída no mobile */
    .table-responsive {
        border-radius: 10px;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
    }
}

/* 9. Scrollbar Customizada Global */
::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 4px; }
::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.5); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.8); }

/* Melhorando header das tabelas */
.table thead th {
    background: rgba(0,0,0,0.2) !important;
    color: #a0aec0 !important;
    border-bottom: 2px solid rgba(255,255,255,0.05) !important;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Efeito de brilho em títulos */
.welcome-bar h2 {
    background: linear-gradient(to right, #ffffff, #a5b4fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 2px 10px rgba(255,255,255,0.1);
}
"""

with open(css_path, "a", encoding="utf-8") as f:
    f.write(premium_css)

print("CSS Premium appended successfully!")
