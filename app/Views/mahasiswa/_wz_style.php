<style>
/* ============ WIZARD STEPPER BAR ============ */
.wizard-stepper-wrap {
    background: #ffffff;
    border-radius: 14px;
    padding: 22px 36px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
    margin-bottom: 24px;
}
.stepper-track { display: flex; align-items: center; justify-content: space-between; list-style: none; padding: 0; margin: 0; }
.stepper-item-wrap { display: flex; align-items: center; flex: 0 0 auto; }
.step-connector { flex: 1; height: 2px; background: #e2e8f0; margin: 0 14px; position: relative; overflow: hidden; border-radius: 2px; }
.step-connector-fill { position: absolute; top: 0; left: 0; height: 100%; width: 0%; background: linear-gradient(90deg, #10b981, #059669); transition: width 0.5s cubic-bezier(0.4,0,0.2,1); border-radius: 2px; }
.step-circle { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.88rem; border: 2px solid #e2e8f0; background: #f8fafc; color: #94a3b8; transition: all 0.35s cubic-bezier(0.4,0,0.2,1); flex-shrink: 0; }
.step-circle.is-active { background: var(--primary-navy); border-color: var(--primary-navy); color: #fff; box-shadow: 0 0 0 5px rgba(10,29,55,0.1); }
.step-circle.is-done { background: #10b981; border-color: #10b981; color: #fff; box-shadow: 0 0 0 4px rgba(16,185,129,0.15); }
.step-info { margin-left: 11px; }
.step-label-num { font-size: 0.68rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; line-height: 1; transition: color 0.3s; }
.step-label-title { font-size: 0.85rem; font-weight: 700; color: #94a3b8; margin-top: 2px; transition: color 0.3s; white-space: nowrap; }
.step-label-title.is-active { color: var(--primary-navy); }
.step-label-title.is-done { color: #059669; }
.step-label-num.is-active { color: var(--accent-blue-soft); }
.step-label-num.is-done { color: #10b981; }

/* ============ WIZARD CARD ============ */
.wizard-card { background: #fff; border-radius: 14px; padding: 36px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.04); }
.wizard-step { display: none; }
.wizard-step.is-active { display: block; animation: wz-slide-in 0.3s cubic-bezier(0.4,0,0.2,1); }
@keyframes wz-slide-in { from { opacity: 0; transform: translateX(18px); } to { opacity: 1; transform: translateX(0); } }
.wz-section-title { font-size: 0.95rem; font-weight: 700; color: var(--primary-navy); padding-bottom: 14px; border-bottom: 1px solid #edf2f7; margin-bottom: 26px; display: flex; align-items: center; gap: 8px; }

/* ============ FORM INPUTS ============ */
.wz-form-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 7px; display: block; }
.wz-form-control, .wz-form-select { border: 1px solid #e2e8f0; border-radius: 9px; padding: 11px 14px; font-size: 0.88rem; color: var(--text-dark); background-color: #fafbfc; transition: all 0.2s ease; width: 100%; }
.wz-form-control:focus, .wz-form-select:focus { background-color: #fff; border-color: var(--accent-blue-soft); box-shadow: 0 0 0 4px rgba(14,165,233,0.1); outline: none; }
textarea.wz-form-control { resize: none; }
.char-counter { font-size: 0.72rem; color: #94a3b8; text-align: right; margin-top: 4px; }
.date-range-wrap { display: grid; grid-template-columns: 1fr auto 1fr; gap: 14px; align-items: end; }
.date-separator { display: flex; align-items: center; justify-content: center; padding-bottom: 3px; color: #94a3b8; font-size: 1rem; }

/* ============ UPLOAD ZONE ============ */
.upload-zone { border: 2px dashed #d1d9e3; border-radius: 11px; padding: 28px 20px; text-align: center; background: #fafbfc; transition: all 0.22s ease; cursor: pointer; position: relative; overflow: hidden; }
.upload-zone:hover, .upload-zone.is-dragging { border-color: var(--accent-blue-soft); background: #f0f9ff; }
.upload-zone.is-filled { border-color: #10b981; background: #f0fdf4; border-style: solid; }
.upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.upload-icon-wrap { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.4rem; background: #e0f2fe; color: var(--accent-blue-soft); transition: transform 0.2s; }
.upload-zone.is-filled .upload-icon-wrap { background: #dcfce7; color: #10b981; }
.upload-zone:hover .upload-icon-wrap { transform: scale(1.1); }

/* ============ REVIEW STEP ============ */
.review-data-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 11px; padding: 22px 24px; margin-bottom: 20px; }
.review-data-card .rv-title { font-size: 0.82rem; font-weight: 700; color: var(--primary-navy); margin-bottom: 16px; display: flex; align-items: center; gap: 7px; }
.rv-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.rv-table tr td { padding: 7px 0; vertical-align: top; line-height: 1.5; }
.rv-table tr td:first-child { width: 40%; font-size: 0.81rem; color: #64748b; font-weight: 500; }
.rv-table tr td.rv-sep { width: 24px; color: #94a3b8; text-align: center; }
.rv-table tr td:last-child { font-size: 0.86rem; font-weight: 600; color: var(--text-dark); }

.rv-doc-table { width: 100%; border-collapse: collapse; border-radius: 11px; overflow: hidden; border: 1px solid #e2e8f0; }
.rv-doc-table thead tr { background: #f1f5f9; }
.rv-doc-table thead th { padding: 11px 16px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border-bottom: 1px solid #e2e8f0; }
.rv-doc-table tbody td { padding: 13px 16px; font-size: 0.86rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; color: var(--text-dark); }
.rv-doc-table tbody tr:last-child td { border-bottom: none; }
.file-chip { display: inline-flex; align-items: center; gap: 6px; background: #fef2f2; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 0.78rem; font-weight: 600; max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ============ SUCCESS STEP ============ */
.success-anim { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 28px; box-shadow: 0 12px 30px rgba(16,185,129,0.35); animation: pop-in 0.55s cubic-bezier(0.34,1.56,0.64,1) forwards; }
@keyframes pop-in { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }

/* ============ NAV BUTTONS ============ */
.wz-btn-primary { display: inline-flex; align-items: center; gap: 8px; background: var(--primary-navy); color: #fff; border: none; padding: 11px 28px; border-radius: 9px; font-weight: 700; font-size: 0.875rem; transition: all 0.22s ease; cursor: pointer; text-decoration: none; }
.wz-btn-primary:hover:not(:disabled) { background: var(--primary-royal); color: #fff; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(10,29,55,0.18); }
.wz-btn-primary:disabled { opacity: 0.65; cursor: not-allowed; }
.wz-btn-secondary { display: inline-flex; align-items: center; gap: 8px; background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; padding: 11px 22px; border-radius: 9px; font-weight: 600; font-size: 0.875rem; transition: all 0.22s ease; cursor: pointer; text-decoration: none; }
.wz-btn-secondary:hover { background: #e2e8f0; color: #475569; border-color: #cbd5e1; }
.wz-btn-success { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; border: none; padding: 11px 28px; border-radius: 9px; font-weight: 700; font-size: 0.875rem; transition: all 0.22s ease; cursor: pointer; text-decoration: none; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
.wz-btn-success:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(16,185,129,0.4); color: #fff; }
.info-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 9px; padding: 14px 16px; }
.warn-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 9px; padding: 14px 16px; }
.wz-nav-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #edf2f7; padding-top: 24px; margin-top: 8px; }
</style>
