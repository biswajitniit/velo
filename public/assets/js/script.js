(() => {
  "use strict";

  /* Global helpers / shared utilities */
  const $ = (selector, scope = document) => scope.querySelector(selector);
  const $$ = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));
  const byId = (id) => document.getElementById(id);
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const isEmail = (value) => emailPattern.test(value);
  const onReady = (callback) => {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", callback, { once: true });
    } else {
      callback();
    }
  };
  const hasBodyClass = (className) => document.body.classList.contains(className);

  function setLoading(button, isLoading) {
    if (!button) return;
    button.classList.toggle("loading", isLoading);
    button.disabled = isLoading;
  }

  function showInlineToast(message) {
    const toast = byId("toast");
    if (!toast) return;

    const messageNode = byId("toastMsg");
    if (messageNode) {
      messageNode.textContent = message;
      toast.classList.add("show");
      clearTimeout(window.__appToastTimer);
      window.__appToastTimer = setTimeout(() => toast.classList.remove("show"), 3000);
      return;
    }

    toast.textContent = message;
    if (toast.classList.contains("dashboard-toast")) {
      toast.style.opacity = "1";
      toast.style.transform = "translateX(-50%) translateY(0)";
      clearTimeout(window.__appToastTimer);
      window.__appToastTimer = setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateX(-50%) translateY(80px)";
      }, 2400);
      return;
    }

    toast.classList.add("show");
    clearTimeout(window.__appToastTimer);
    window.__appToastTimer = setTimeout(() => toast.classList.remove("show"), 3200);
  }

  function setActiveNavItem(element) {
    if (!element) return;
    $$(".nav-item").forEach((item) => item.classList.remove("active"));
    element.classList.add("active");
  }

  function togglePageSidebar() {
    const sidebar = byId("sidebar");
    const overlay = byId("overlay") || byId("sidebarOverlay");
    if (!sidebar) return;
    sidebar.classList.toggle("open");
    if (overlay) {
      overlay.classList.toggle("visible");
      overlay.classList.toggle("open");
    }
  }

  function closePageSidebar() {
    const sidebar = byId("sidebar");
    const overlay = byId("overlay") || byId("sidebarOverlay");
    if (sidebar) sidebar.classList.remove("open");
    if (overlay) {
      overlay.classList.remove("visible");
      overlay.classList.remove("open");
    }
  }

  function toggleDashboardSidebar() {
    if (!hasBodyClass("dashboard-page")) return;
    if (window.matchMedia("(max-width: 960px)").matches) {
      togglePageSidebar();
      return;
    }
    const collapsed = document.body.classList.toggle("dashboard-sidebar-collapsed");
    $(".sidebar-toggle-btn")?.setAttribute("aria-expanded", String(!collapsed));
  }

  /* Website-level scripts */
  function initReveal(selector, options = {}) {
    const elements = $$(selector);
    if (!elements.length || !("IntersectionObserver" in window)) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        if (options.className) {
          entry.target.classList.add(options.className);
        } else {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
        }
        observer.unobserve(entry.target);
      });
    }, { threshold: options.threshold || 0.1 });

    elements.forEach((element) => {
      if (options.prepare) options.prepare(element);
      observer.observe(element);
    });
  }

  function initHomePage() {
    if (!hasBodyClass("home-page")) return;

    $$(".feature-card, .plan-card, .testimonial-card, .how-step").forEach((element) => {
      element.classList.add("reveal");
    });
    initReveal(".reveal", { className: "is-visible", threshold: 0.12 });

    $$(".how-step").forEach((step) => {
      step.addEventListener("click", () => {
        $$(".how-step").forEach((item) => item.classList.remove("active"));
        step.classList.add("active");
      });
    });
  }

  function toggleFaq(element) {
    const item = element && element.closest(".faq-item");
    if (!item) return;
    const isOpen = item.classList.contains("open");
    $$(".faq-item").forEach((faq) => faq.classList.remove("open"));
    if (!isOpen) item.classList.add("open");
  }

  function setStep(element) {
    $$(".how-step").forEach((step) => step.classList.remove("active"));
    if (element) element.classList.add("active");
  }

  function initInvoiceProWebsite() {
    if (!hasBodyClass("invoicepro-page")) return;
    initReveal(".feature-card, .testimonial-card, .plan-card, .portal-feat", {
      prepare(element) {
        element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        element.style.opacity = "0";
        element.style.transform = "translateY(20px)";
      }
    });
  }

  /* Auth scripts */
  function initAuthPage() {
    const loginForm = byId("loginForm");
    if (!loginForm) return;

    const selectors = {
      tabs: "[data-auth-tab]",
      forms: {
        login: "loginForm",
        signup: "signupForm",
        forgot: "forgotForm"
      }
    };

    function clearValidation(scope = document) {
      $$(".is-invalid", scope).forEach((field) => field.classList.remove("is-invalid"));
      $$(".auth-alert", scope).forEach((alert) => alert.classList.add("d-none"));
    }

    function setFieldError(field, hasError) {
      if (field) field.classList.toggle("is-invalid", hasError);
    }

    function activateTab(tab) {
      clearValidation();
      byId("login-tab")?.classList.toggle("active", tab === "login");
      byId("signup-tab")?.classList.toggle("active", tab === "signup");
      byId("login-tab")?.setAttribute("aria-selected", String(tab === "login"));
      byId("signup-tab")?.setAttribute("aria-selected", String(tab === "signup"));
      byId(selectors.forms.login)?.classList.toggle("is-visible", tab === "login");
      byId(selectors.forms.signup)?.classList.toggle("is-visible", tab === "signup");
      byId(selectors.forms.forgot)?.classList.remove("is-visible");
    }

    function showForgot() {
      clearValidation();
      byId(selectors.forms.login)?.classList.remove("is-visible");
      byId(selectors.forms.signup)?.classList.remove("is-visible");
      byId(selectors.forms.forgot)?.classList.add("is-visible");
    }

    function hideForgot() {
      const forgotForm = byId(selectors.forms.forgot);
      forgotForm?.reset();
      $(".forgot-input-group", forgotForm)?.classList.remove("d-none");
      byId("forgotSubmit")?.classList.remove("d-none", "loading");
      if (byId("forgotSubmit")) byId("forgotSubmit").disabled = false;
      byId("forgotSuccess")?.classList.remove("is-visible");
      activateTab("login");
    }

    function togglePassword(button) {
      const input = byId(button.dataset.togglePassword);
      if (!input) return;
      const isHidden = input.type === "password";
      input.type = isHidden ? "text" : "password";
      button.setAttribute("aria-label", isHidden ? "Hide password" : "Show password");
      button.innerHTML = isHidden
        ? '<svg viewBox="0 0 16 16" aria-hidden="true"><path d="M2 2l12 12M6.5 6.6A2 2 0 0 0 9.4 9.4M1 8s2.5-4 7-4c.8 0 1.6.1 2.3.4M13.3 10.7C11.9 12.1 10 13 8 13c-4.5 0-7-5-7-5"/></svg>'
        : '<svg viewBox="0 0 16 16" aria-hidden="true"><path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/><circle cx="8" cy="8" r="2"/></svg>';
    }

    function updateStrength(value) {
      const meter = byId("strengthMeter");
      const label = byId("strengthLabel");
      if (!meter || !label) return;

      if (!value) {
        meter.classList.add("d-none");
        meter.removeAttribute("data-strength");
        label.textContent = "";
        return;
      }

      let score = 0;
      if (value.length >= 8) score += 1;
      if (/[A-Z]/.test(value)) score += 1;
      if (/[0-9]/.test(value)) score += 1;
      if (/[^A-Za-z0-9]/.test(value)) score += 1;

      const names = ["", "Weak", "Fair", "Good", "Strong"];
      const keys = ["", "weak", "fair", "good", "strong"];
      const colors = ["", "#c94040", "#c9832a", "#2e9969", "#1a6b4a"];

      meter.classList.remove("d-none");
      meter.dataset.strength = keys[score];
      label.textContent = `${names[score]} password`;
      label.style.color = colors[score];
    }

    function handleLogin(event) {
      event.preventDefault();
      const email = byId("loginEmail");
      const password = byId("loginPassword");
      const submit = byId("loginSubmit");

      clearValidation(loginForm);
      setFieldError(email, !isEmail(email.value.trim()));
      setFieldError(password, password.value.length === 0);
      if (loginForm.querySelector(".is-invalid")) return;

      setLoading(submit, true);
      window.setTimeout(() => {
        setLoading(submit, false);
        if (email.value.trim().toLowerCase() === "demo@velo.com" && password.value === "password123") {
          window.location.href = "/subscriber/dashboard";
          return;
        }
        byId("loginError")?.classList.remove("d-none");
        setFieldError(email, true);
        setFieldError(password, true);
      }, 1200);
    }

    function handleSignup(event) {
      event.preventDefault();
      const form = event.currentTarget;
      const submit = byId("signupSubmit");

      clearValidation(form);
      setFieldError(byId("firstName"), byId("firstName").value.trim().length === 0);
      setFieldError(byId("lastName"), byId("lastName").value.trim().length === 0);
      setFieldError(byId("signupEmail"), !isEmail(byId("signupEmail").value.trim()));
      setFieldError(byId("signupPassword"), byId("signupPassword").value.length < 8);
      if (form.querySelector(".is-invalid")) return;

      setLoading(submit, true);
      window.setTimeout(() => {
        setLoading(submit, false);
        submit.classList.add("is-success");
        $(".btn-text", submit).textContent = "Account created! Redirecting...";
      }, 1300);
    }

    function handleForgot(event) {
      event.preventDefault();
      const form = event.currentTarget;
      const email = byId("forgotEmail");
      const submit = byId("forgotSubmit");
      const error = byId("forgotError");

      error?.classList.add("d-none");
      if (!isEmail(email.value.trim())) {
        error?.classList.remove("d-none");
        setFieldError(email, true);
        return;
      }

      setLoading(submit, true);
      window.setTimeout(() => {
        setLoading(submit, false);
        submit.classList.add("d-none");
        $(".forgot-input-group", form)?.classList.add("d-none");
        byId("forgotEmailShow").textContent = email.value.trim();
        byId("forgotSuccess").classList.add("is-visible");
      }, 1100);
    }

    function handleSocial(provider) {
      const label = provider === "apple" ? "Apple" : "Google";
      window.alert(`Redirecting to ${label} OAuth...\n\nConnect your OAuth provider in the backend to enable this.`);
    }

    $$(selectors.tabs).forEach((trigger) => {
      trigger.addEventListener("click", () => activateTab(trigger.dataset.authTab));
    });
    $$("[data-toggle-password]").forEach((button) => {
      button.addEventListener("click", () => togglePassword(button));
    });
    $$("[data-social]").forEach((button) => {
      button.addEventListener("click", () => handleSocial(button.dataset.social));
    });

    loginForm.addEventListener("submit", handleLogin);
    byId("signupForm")?.addEventListener("submit", handleSignup);
    byId("forgotForm")?.addEventListener("submit", handleForgot);
    byId("signupPassword")?.addEventListener("input", (event) => updateStrength(event.target.value));
    byId("loginEmail")?.addEventListener("input", () => byId("loginError")?.classList.add("d-none"));
    byId("loginPassword")?.addEventListener("input", () => byId("loginError")?.classList.add("d-none"));
    byId("forgotEmail")?.addEventListener("input", (event) => {
      event.target.classList.remove("is-invalid");
      byId("forgotError")?.classList.add("d-none");
    });
    $("[data-show-forgot]")?.addEventListener("click", showForgot);
    $("[data-hide-forgot]")?.addEventListener("click", hideForgot);
    $$(".form-control").forEach((field) => {
      field.addEventListener("input", () => field.classList.remove("is-invalid"));
    });
  }

  /* Dashboard scripts */
  function toggleTask(element) {
    if (element) element.classList.toggle("task-done");
  }

  function initDashboardPage() {
    if (!hasBodyClass("dashboard-page")) return;
    window.toast = showInlineToast;
  }

  /* Company profile scripts */
  const companyProfileState = {
    smsEnabled: true,
    displayNameEnabled: true,
    trackedFields: ["firstName", "lastName", "email", "companyName", "addressLine1", "city", "mobile"]
  };

  function formatPhone(input) {
    let raw = input.value.replace(/\D/g, "").slice(0, 10);
    if (raw.length >= 7) raw = `(${raw.slice(0, 3)}) ${raw.slice(3, 6)}-${raw.slice(6)}`;
    else if (raw.length >= 4) raw = `(${raw.slice(0, 3)}) ${raw.slice(3)}`;
    else if (raw.length > 0) raw = `(${raw}`;
    input.value = raw;
  }

  function toggleDisplayName() {
    companyProfileState.displayNameEnabled = !companyProfileState.displayNameEnabled;
    byId("dnCheckbox")?.classList.toggle("checked", companyProfileState.displayNameEnabled);
  }

  function toggleSms() {
    companyProfileState.smsEnabled = !companyProfileState.smsEnabled;
    byId("smsOptin")?.classList.toggle("unchecked", !companyProfileState.smsEnabled);
  }

  function handleLogoUpload(input) {
    const file = input.files[0];
    if (!file) return;
    byId("logoImg").src = URL.createObjectURL(file);
    byId("logoName").textContent = file.name;
    byId("logoSize").textContent = `${(file.size / 1024).toFixed(1)} KB`;
    byId("logoPreview").style.display = "flex";
    byId("uploadArea").style.borderStyle = "solid";
    byId("uploadArea").style.borderColor = "var(--teal)";
  }

  function removeLogo() {
    byId("logoInput").value = "";
    byId("logoPreview").style.display = "none";
    byId("uploadArea").style.borderStyle = "dashed";
    byId("uploadArea").style.borderColor = "var(--border)";
  }

  function trackProgress() {
    let filled = 0;
    companyProfileState.trackedFields.forEach((id) => {
      const element = byId(id);
      if (element && element.value.trim()) filled += 1;
    });
    if (byId("industry")?.value) filled += 1;

    const total = companyProfileState.trackedFields.length + 1;
    const pct = Math.round((filled / total) * 100);
    if (byId("progressFill")) byId("progressFill").style.width = `${pct}%`;
    if (byId("progressPct")) byId("progressPct").textContent = `${pct}%`;
    if (byId("progressCount")) byId("progressCount").textContent = `${filled} / ${total} fields`;
  }

  function validateCompanyProfile() {
    let ok = true;
    const required = [
      ["firstName", "firstNameErr"],
      ["lastName", "lastNameErr"],
      ["email", "emailErr"],
      ["companyName", "companyNameErr"],
      ["addressLine1", "addressErr"],
      ["city", "cityErr"],
      ["mobile", "mobileErr"]
    ];

    required.forEach(([id, errId]) => {
      const input = byId(id);
      const error = byId(errId);
      if (!input || !error) return;
      const invalid = !input.value.trim();
      input.classList.toggle("error", invalid);
      error.style.display = invalid ? "block" : "none";
      if (invalid) ok = false;
    });

    const emailInput = byId("email");
    if (emailInput?.value && !isEmail(emailInput.value)) {
      emailInput.classList.add("error");
      byId("emailErr").textContent = "Please enter a valid email address.";
      byId("emailErr").style.display = "block";
      ok = false;
    }
    return ok;
  }

  function shakeButton(button) {
    if (!button) return;
    button.style.transform = "translateX(-6px)";
    setTimeout(() => { button.style.transform = "translateX(6px)"; }, 80);
    setTimeout(() => { button.style.transform = "translateX(-4px)"; }, 160);
    setTimeout(() => { button.style.transform = "translateX(4px)"; }, 240);
    setTimeout(() => { button.style.transform = ""; }, 320);
  }

  function showCompanySuccess() {
    const form = byId("profileForm");
    const screen = byId("successScreen");
    if (!form || !screen) return;

    const location = [byId("city")?.value, byId("state")?.value, byId("country")?.value].filter(Boolean).join(", ") || "—";
    const rows = [
      ["Name", `${byId("firstName")?.value || "—"} ${byId("lastName")?.value || "—"}`],
      ["Email", byId("email")?.value || "—"],
      ["Company", byId("companyName")?.value || "—"],
      ["Location", location],
      ["Mobile", byId("mobile")?.value || "—"],
      ["SMS alerts", companyProfileState.smsEnabled ? "✓ Enabled" : "✕ Disabled"]
    ];

    byId("summaryCard").innerHTML = rows
      .map(([key, value]) => `<div class="sc-row"><span class="sc-key">${key}</span><span class="sc-val">${value}</span></div>`)
      .join("");

    form.style.display = "none";
    screen.style.display = "flex";
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  function handleCompanySubmit() {
    if (!validateCompanyProfile()) {
      shakeButton(byId("submitBtn"));
      $(".error")?.scrollIntoView({ behavior: "smooth", block: "center" });
      return;
    }
    const button = byId("submitBtn");
    button.classList.add("loading");
    setTimeout(() => {
      button.classList.remove("loading");
      showCompanySuccess();
    }, 1800);
  }

  function initCompanyProfilePage() {
    if (!hasBodyClass("company-profile-page")) return;
    $$("input, select").forEach((element) => {
      element.addEventListener("input", () => {
        element.classList.remove("error");
        const error = byId(`${element.id}Err`);
        if (error) error.style.display = "none";
      });
    });
  }

  /* Client portal scripts */
  function filterPill(element) {
    element?.closest(".filter-row")?.querySelectorAll(".pill").forEach((pill) => pill.classList.remove("active"));
    element?.classList.add("active");
  }

  function filterByProject(project, element = window.event?.currentTarget) {
    $$(".proj-card").forEach((card) => card.classList.remove("selected"));
    element?.classList.add("selected");
    showInlineToast(project === "all" ? "Showing all projects" : `Filtered to project: ${project}`);
  }

  function openModal(id) {
    byId(id)?.classList.add("open");
  }

  function closeModal(id) {
    byId(id)?.classList.remove("open");
  }

  function setPayAmount(value) {
    if (byId("payAmount")) byId("payAmount").value = value;
  }

  function submitPayment() {
    const amount = byId("payAmount")?.value || "0.00";
    closeModal("payModal");
    showInlineToast(`Payment of $${amount} submitted successfully! ✓`);
  }

  function closeModalOnOverlay(event) {
    if (event.target.classList.contains("modal-overlay")) event.target.classList.remove("open");
  }

  function submitExport() {
    closeModal("exportModal");
    showInlineToast("Export started — your file will download shortly");
  }

  function triggerUpload() {
    byId("fileUpload")?.click();
  }

  function handleUpload(event) {
    const file = event.target.files[0];
    if (file) showInlineToast(`"${file.name}" uploaded successfully!`);
  }

  function initClientPortalPage() {
    if (!hasBodyClass("client-portal-page")) return;
    $$('a[href^="#"]').forEach((link) => {
      link.addEventListener("click", (event) => {
        const target = $(link.getAttribute("href"));
        if (!target) return;
        event.preventDefault();
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      });
    });
  }

  /* Default preferences scripts */
  const defaultsState = {
    configured: new Set(),
    total: 11,
    navIds: ["banking", "clients", "documents", "integrations", "invoices", "items", "notifications", "payments", "projects", "reports", "repository"]
  };

  function updateDefaultsNavHighlight(activeId) {
    $$(".defaults-page .nav-link").forEach((link, index) => {
      link.classList.toggle("active", defaultsState.navIds[index] === activeId);
    });
  }

  function togglePreferenceSection(header) {
    if (!header) return;
    const body = header.nextElementSibling;
    const isOpen = body.classList.contains("open");

    $$(".defaults-page .section-body").forEach((section) => section.classList.remove("open"));
    $$(".defaults-page .section-header").forEach((item) => {
      item.classList.remove("open");
      $(".chevron", item)?.classList.remove("open");
    });

    if (!isOpen) {
      body.classList.add("open");
      header.classList.add("open");
      $(".chevron", header)?.classList.add("open");
      updateDefaultsNavHighlight(header.closest(".pref-section").id);
    }
  }

  function updateDefaultsProgress() {
    const progress = Math.round((defaultsState.configured.size / defaultsState.total) * 100);
    if (byId("progressFill")) byId("progressFill").style.width = `${progress}%`;
    if (byId("progressPct")) byId("progressPct").textContent = `${defaultsState.configured.size} / ${defaultsState.total}`;
    if (defaultsState.configured.size > 0 && byId("footerNote")) {
      byId("footerNote").innerHTML = `<strong>${defaultsState.configured.size} of ${defaultsState.total}</strong> sections configured.`;
    }
  }

  function markConfigured(id) {
    defaultsState.configured.add(id);
    const status = byId(`status-${id}`);
    if (status) {
      status.textContent = "Configured";
      status.className = "section-status status-configured";
    }
    updateDefaultsProgress();
  }

  function selectChip(element, group) {
    const selector = group ? `.chip[onclick*="${group}"]` : ".chip";
    element?.closest(".chip-group")?.querySelectorAll(selector).forEach((chip) => chip.classList.remove("active"));
    element?.classList.add("active");
  }

  function toggleChip(element) {
    element?.classList.toggle("active");
  }

  function toggleCheck(element) {
    element?.classList.toggle("checked");
  }

  function selectSwatch(element) {
    element?.closest(".color-swatches")?.querySelectorAll(".swatch").forEach((swatch) => swatch.classList.remove("active"));
    element?.classList.add("active");
  }

  function stepVal(id, delta) {
    const input = byId(id);
    if (!input) return;
    input.value = Math.max(parseFloat(input.min) || 0, parseFloat(input.value || 0) + delta);
  }

  const nativeScrollTo = window.scrollTo.bind(window);
  function preferenceScrollTo(idOrOptions, y) {
    if (typeof idOrOptions !== "string") {
      nativeScrollTo(idOrOptions, y);
      return;
    }

    const element = byId(idOrOptions);
    if (!element) return;
    if (!$(".section-body.open", element)) togglePreferenceSection($(".section-header", element));
    setTimeout(() => element.scrollIntoView({ behavior: "smooth", block: "start" }), 50);
    updateDefaultsNavHighlight(idOrOptions);
  }

  function saveAllPreferences() {
    defaultsState.navIds.forEach((id) => markConfigured(id));
    showInlineToast("✓ All preferences saved successfully!");
  }

  function handlePreferencesContinue() {
    if (defaultsState.configured.size === 0) {
      showInlineToast("Configure at least one section, or click Skip.");
      return;
    }
    const button = byId("continueBtn");
    button.innerHTML = '<span class="saving-spinner">⟳</span> Saving...';
    setTimeout(() => {
      button.innerHTML = "✓ Saved! Heading to Step 4...";
      button.style.background = "var(--teal)";
      showInlineToast("Preferences saved! Welcome to Velo.");
    }, 1400);
  }

  function initDefaultsPreferencesPage() {
    if (!hasBodyClass("defaults-page")) return;

    if ("IntersectionObserver" in window) {
      const spy = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) updateDefaultsNavHighlight(entry.target.id);
        });
      }, { rootMargin: "-25% 0px -60% 0px" });
      $$(".pref-section").forEach((section) => spy.observe(section));
    }

    window.addEventListener("load", () => {
      const first = $(".pref-section .section-header");
      if (first) togglePreferenceSection(first);
    }, { once: true });
  }

  /* Expose existing inline-handler API. */
  Object.assign(window, {
    closeExportModal: () => closeModal("exportModal"),
    closeModalOnOverlay,
    closePayModal: () => closeModal("payModal"),
    closeSidebar: closePageSidebar,
    filterByProject,
    filterPill,
    formatPhone,
    handleContinue: handlePreferencesContinue,
    handleLogoUpload,
    handleSubmit: handleCompanySubmit,
    handleUpload,
    markConfigured,
    openExportModal: () => openModal("exportModal"),
    openPayModal: () => openModal("payModal"),
    removeLogo,
    saveAll: saveAllPreferences,
    scrollTo: preferenceScrollTo,
    selectChip,
    selectSwatch,
    setActive: setActiveNavItem,
    setPayAmount,
    setStep,
    showSuccess: showCompanySuccess,
    showToast: showInlineToast,
    stepVal,
    submitExport,
    submitPayment,
    toast: showInlineToast,
    toggleCheck,
    toggleChip,
    toggleDisplayName,
    toggleFaq,
    toggleDashboardSidebar,
    toggleSection: togglePreferenceSection,
    toggleSidebar: togglePageSidebar,
    toggleSms,
    toggleTask,
    trackProgress,
    triggerUpload
  });

  onReady(() => {
    initHomePage();
    initInvoiceProWebsite();
    initAuthPage();
    initDashboardPage();
    initCompanyProfilePage();
    initClientPortalPage();
    initDefaultsPreferencesPage();
  });
})();
