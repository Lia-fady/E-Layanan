<style>
/* ============ WIZARD STEPPER BAR ============ */
.wizard-stepper-wrap {
    background: #fff;
    border-radius: 6px;
    padding: 18px 24px;
    border: 1px solid #dee2e6;
    margin-bottom: 20px;
}
.stepper-track { display: flex; align-items: center; justify-content: space-between; list-style: none; padding: 0; margin: 0; }
.stepper-item-wrap { display: flex; align-items: center; flex: 0 0 auto; }
.step-connector { flex: 1; height: 2px; background: #dee2e6; margin: 0 12px; position: relative; overflow: hidden; }
.step-connector-fill { position: absolute; top: 0; left: 0; height: 100%; width: 0%; background: #198754; transition: width 0.4s ease; }
.step-circle { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; border: 2px solid #dee2e6; background: #f8f9fa; color: #6c757d; transition: all 0.3s ease; flex-shrink: 0; }
.step-circle.is-active { background: #0d6efd; border-color: #0d6efd; color: #fff; }
.step-circle.is-done { background: #198754; border-color: #198754; color: #fff; }
.step-info { margin-left: 10px; }
.step-label-num { font-size: 0.7rem; color: #6c757d; font-weight: 500; text-transform: uppercase; letter-spacing: 0.3px; line-height: 1; }
.step-label-title { font-size: 0.85rem; font-weight: 600; color: #6c757d; margin-top: 2px; white-space: nowrap; }
.step-label-title.is-active { color: #0d6efd; }
.step-label-title.is-done { color: #198754; }
.step-label-num.is-active { color: #0d6efd; }
.step-label-num.is-done { color: #198754; }

/* ============ WIZARD CARD ============ */
.wizard-card { background: #fff; border-radius: 6px; padding: 28px; border: 1px solid #dee2e6; }
.wizard-step { display: none; }
.wizard-step.is-active { display: block; }
.wz-section-title { font-size: 1rem; font-weight: 600; color: #212529; padding-bottom: 12px; border-bottom: 1px solid #dee2e6; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

/* ============ FORM INPUTS ============ */
.wz-form-label { font-size: 0.875rem; font-weight: 500; color: #212529; margin-bottom: 6px; display: block; }
.wz-form-control, .wz-form-select { border: 1px solid #ced4da; border-radius: 5px; padding: 8px 12px; font-size: 0.875rem; color: #212529; background-color: #fff; width: 100%; }
.wz-form-control:focus, .wz-form-select:focus { border-color: #86b7fe; outline: 0; box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25); }
textarea.wz-form-control { resize: vertical; }
.char-counter { font-size: 0.75rem; color: #6c757d; text-align: right; margin-top: 4px; }

/* ============ REVIEW STEP ============ */
.review-data-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 20px; margin-bottom: 16px; }
.review-data-card .rv-title { font-size: 0.9rem; font-weight: 600; color: #212529; margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }
.rv-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.rv-table tr td { padding: 6px 0; vertical-align: top; line-height: 1.5; font-size: 0.875rem; }
.rv-table tr td:first-child { width: 38%; color: #6c757d; font-weight: 500; }
.rv-table tr td.rv-sep { width: 20px; color: #adb5bd; text-align: center; }
.rv-table tr td:last-child { color: #212529; }

.rv-doc-table { width: 100%; border-collapse: collapse; border: 1px solid #dee2e6; border-radius: 6px; overflow: hidden; }
.rv-doc-table thead tr { background: #f8f9fa; }
.rv-doc-table thead th { padding: 10px 14px; font-size: 0.8rem; font-weight: 600; color: #495057; border-bottom: 1px solid #dee2e6; }
.rv-doc-table tbody td { padding: 10px 14px; font-size: 0.875rem; vertical-align: middle; border-bottom: 1px solid #f1f3f5; color: #212529; }
.rv-doc-table tbody tr:last-child td { border-bottom: none; }
.file-chip { display: inline-flex; align-items: center; gap: 5px; color: #0d6efd; font-size: 0.8rem; font-weight: 500; }

/* ============ SUCCESS STEP ============ */
.success-anim { width: 72px; height: 72px; border-radius: 50%; background: #198754; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }

/* ============ NAV BUTTONS ============ */
.wz-btn-primary { display: inline-flex; align-items: center; gap: 8px; background: #0d6efd; color: #fff; border: none; padding: 9px 22px; border-radius: 5px; font-weight: 500; font-size: 0.875rem; cursor: pointer; text-decoration: none; }
.wz-btn-primary:hover:not(:disabled) { background: #0b5ed7; color: #fff; }
.wz-btn-primary:disabled { opacity: 0.65; cursor: not-allowed; }
.wz-btn-secondary { display: inline-flex; align-items: center; gap: 8px; background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 9px 22px; border-radius: 5px; font-weight: 500; font-size: 0.875rem; cursor: pointer; text-decoration: none; }
.wz-btn-secondary:hover { background: #f8f9fa; color: #495057; border-color: #ced4da; }
.wz-btn-success { display: inline-flex; align-items: center; gap: 8px; background: #198754; color: #fff; border: none; padding: 9px 22px; border-radius: 5px; font-weight: 500; font-size: 0.875rem; cursor: pointer; text-decoration: none; }
.wz-btn-success:hover { background: #157347; color: #fff; }
.info-box { background: #e7f1ff; border: 1px solid #b6d4fe; border-radius: 5px; padding: 14px 16px; }
.warn-box { background: #fff3cd; border: 1px solid #ffecb5; border-radius: 5px; padding: 14px 16px; }
.wz-nav-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #dee2e6; padding-top: 20px; margin-top: 10px; }

@media (max-width: 767.98px) {
    .wizard-stepper-wrap { padding: 14px; overflow-x: auto; }
    .stepper-track { min-width: 580px; }
    .step-info { margin-left: 8px; }
    .step-label-title { font-size: 0.78rem; }
    .wizard-card { padding: 18px; }
    .wz-nav-footer { gap: 10px; flex-wrap: wrap; }
    .wz-nav-footer > * { flex: 1 1 auto; justify-content: center; }
    .rv-table tr td:first-child { width: 42%; }
}
</style>
