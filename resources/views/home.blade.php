@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

    <!-- HERO -->
    <section class="hero">
        <div class="hero-badge fade-up">
            <span class="hero-badge-dot"></span>
            Payments, quotes & client portals — all in one place
        </div>
        <h1 class="fade-up delay-1">Invoice faster.<br><em>Get paid sooner.</em></h1>
        <p class="hero-sub fade-up delay-2">Velo gives growing businesses a professional platform to send quotes, invoices,
            receive payments, and give clients their own branded portal — without the chaos.</p>
        <div class="hero-actions fade-up delay-3">
            <a href="#" class="btn btn-accent btn-lg">Start free — 14 days</a>
            <a href="#" class="btn btn-ghost btn-lg">See a demo ↗</a>
        </div>
        <div class="hero-trust fade-up delay-4">
            <div class="avatar-row">
                <div class="hero-avatars">
                    <div class="avatar a1">JL</div>
                    <div class="avatar a2">MR</div>
                    <div class="avatar a3">SK</div>
                    <div class="avatar a4">TC</div>
                    <div class="avatar a5">DW</div>
                </div>
                <span class="hero-count">Trusted by <strong>4,200+</strong> businesses</span>
            </div>
            <span class="hero-trust-text">★★★★★ &nbsp;4.9 / 5 average rating</span>
        </div>
    </section>

    <!-- DASHBOARD PREVIEW -->
    <div class="preview-wrap">
        <div class="dashboard-frame float">
            <div class="dash-topbar">
                <div class="dash-dot d1"></div>
                <div class="dash-dot d2"></div>
                <div class="dash-dot d3"></div>
                <span class="dash-title">app.velobiz.com — Dashboard</span>
            </div>
            <div class="dash-body">
                <div class="dash-sidebar">
                    <div class="dash-sb-logo">Velo<span>.</span></div>
                    <div class="dash-nav-item active"><span class="dash-nav-icon">▦</span> Dashboard</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">📄</span> Invoices</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">💬</span> Quotes</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">💳</span> Payments</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">👥</span> Customers</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">📁</span> Projects</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">📦</span> Items</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">🗂️</span> Documents</div>
                    <div class="dash-nav-item"><span class="dash-nav-icon">⚙️</span> Settings</div>
                </div>
                <div class="dash-content">
                    <div class="dash-header">
                        <span class="dash-page-title">Dashboard</span>
                        <a href="{{ route('subscriber.invoices.create') }}" class="btn btn-primary btn-new-invoice">+ New Invoice</a>
                    </div>
                    <div class="dash-stats">
                        <div class="stat-card">
                            <div class="stat-label">Revenue (MTD)</div>
                            <div class="stat-val">$24,810</div>
                            <div class="stat-change">↑ 18% vs last month</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Outstanding</div>
                            <div class="stat-val">$8,340</div>
                            <div class="stat-change stat-warning">3 invoices due</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Quotes sent</div>
                            <div class="stat-val">12</div>
                            <div class="stat-change">↑ 4 this week</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Active clients</div>
                            <div class="stat-val">47</div>
                            <div class="stat-change">↑ 5 new</div>
                        </div>
                    </div>
                    <div class="dash-table-wrap">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Due date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#INV-1042</td>
                                    <td>Acme Corp</td>
                                    <td>$4,200.00</td>
                                    <td>Mar 30, 2026</td>
                                    <td><span class="status-pill s-paid">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>#INV-1041</td>
                                    <td>Blue Harbor LLC</td>
                                    <td>$1,850.00</td>
                                    <td>Apr 05, 2026</td>
                                    <td><span class="status-pill s-pending">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>#INV-1040</td>
                                    <td>Studio Nora</td>
                                    <td>$950.00</td>
                                    <td>Mar 20, 2026</td>
                                    <td><span class="status-pill s-overdue">Overdue</span></td>
                                </tr>
                                <tr>
                                    <td>#INV-1039</td>
                                    <td>Reston Group</td>
                                    <td>$3,100.00</td>
                                    <td>Apr 12, 2026</td>
                                    <td><span class="status-pill s-draft">Draft</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="features-section" id="features">
        <div class="features-header">
            <div class="section-label">Everything you need</div>
            <h2>One platform, zero <em>friction</em></h2>
            <p class="section-sub section-sub-centered">Every tool a professional service business needs — invoicing,
                quoting, payments, project management, and client portals — working together out of the box.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon fi-green">📄</div>
                <div class="feature-title">Quotes & Invoices</div>
                <div class="feature-desc">Create beautiful, branded quotes and invoices in seconds. Convert accepted quotes
                    to invoices with one click. Track every status from draft to paid.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-gold">💳</div>
                <div class="feature-title">Online Payments</div>
                <div class="feature-desc">Accept credit cards, bank transfers, and digital wallets via Stripe. Customers pay
                    directly from their portal or invoice email — no chasing required.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-blue">👥</div>
                <div class="feature-title">Customer Database</div>
                <div class="feature-desc">Maintain a rich customer directory with contacts, billing info, payment history,
                    and notes. Search and filter with ease, and tag clients by segment.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-purple">📁</div>
                <div class="feature-title">Project Management</div>
                <div class="feature-desc">Organize work into projects tied to clients. Track progress, assign billing, and
                    keep everything connected — from initial quote to final invoice.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-red">📦</div>
                <div class="feature-title">Items & Services</div>
                <div class="feature-desc">Build a reusable catalog of products and services with custom rates, tax
                    settings, and descriptions. Populate invoices in seconds, not minutes.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon fi-teal">🗂️</div>
                <div class="feature-title">Document Sharing</div>
                <div class="feature-desc">Upload contracts, specs, reports, and any files to share with clients. Grant
                    granular access per customer — they view documents from their secure portal.</div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how-it-works" class="surface-section">
        <div class="how-wrap">
            <div>
                <div class="section-label">How it works</div>
                <h2>Up and running<br><em>in minutes</em></h2>
                <div class="how-steps how-steps-spaced">
                    <div class="how-step active" onclick="setStep(this, 0)">
                        <div class="how-num">1</div>
                        <div>
                            <div class="how-step-title">Set up your business profile</div>
                            <div class="how-step-desc">Add your logo, brand colors, and payment details. Velo auto-applies
                                your branding to every invoice, quote, and client portal.</div>
                        </div>
                    </div>
                    <div class="how-step" onclick="setStep(this, 1)">
                        <div class="how-num">2</div>
                        <div>
                            <div class="how-step-title">Add customers, projects & items</div>
                            <div class="how-step-desc">Import or create your customer database. Build your service catalog.
                                Organize work into projects so billing is always connected to context.</div>
                        </div>
                    </div>
                    <div class="how-step" onclick="setStep(this, 2)">
                        <div class="how-num">3</div>
                        <div>
                            <div class="how-step-title">Send quotes and invoices</div>
                            <div class="how-step-desc">Draft a quote, send it for e-sign approval, then convert it to an
                                invoice instantly. Payment links are embedded automatically.</div>
                        </div>
                    </div>
                    <div class="how-step" onclick="setStep(this, 3)">
                        <div class="how-num">4</div>
                        <div>
                            <div class="how-step-title">Grant clients their portal</div>
                            <div class="how-step-desc">Each customer gets a private login to view invoices, pay online,
                                access documents, and track their project status — all branded to you.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="how-visual">
                <div class="portal-card float" id="step-visual">
                    <div class="portal-header">
                        <div class="portal-logo">Acme Corp Portal</div>
                        <div class="portal-subtitle">Powered by Velo · acme.velobiz.com</div>
                    </div>
                    <div class="portal-body">
                        <div class="portal-row"><span class="portal-row-label">Invoice #INV-1042</span><span
                                class="portal-row-val">$4,200.00</span></div>
                        <div class="portal-row"><span class="portal-row-label">Status</span><span
                                class="status-pill s-paid">Paid</span></div>
                        <div class="portal-row"><span class="portal-row-label">Project</span><span
                                class="portal-row-val">Website Redesign</span></div>
                        <div class="portal-row"><span class="portal-row-label">Contract PDF</span><span
                                class="portal-link">View ↗</span></div>
                        <div class="portal-action">
                            <div class="pa-btn pa-primary">Pay Now</div>
                            <div class="pa-btn pa-secondary">Download</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CLIENT PORTAL -->
    <section class="portal-section" id="portal">
        <div class="section-label">Client portal</div>
        <h2>Your clients deserve<br><em>a first-class experience</em></h2>
        <p class="section-sub">Every subscriber gets a branded customer portal they can invite clients to. No logins
            shared, no email chains — just a clean, professional space.</p>
        <div class="portal-grid">
            <div class="portal-features">
                <div class="portal-feat">
                    <div class="pf-icon">📬</div>
                    <div>
                        <div class="pf-title">View invoices & quotes</div>
                        <div class="pf-desc">Clients see all their billing history in one place, including status, amounts
                            due, and payment history — no more "can you resend that invoice?" emails.</div>
                    </div>
                </div>
                <div class="portal-feat">
                    <div class="pf-icon">💸</div>
                    <div>
                        <div class="pf-title">Pay securely online</div>
                        <div class="pf-desc">One-click payment from the portal or an invoice link. Cards, ACH, and digital
                            wallets accepted. Instant payment confirmation sent to both parties.</div>
                    </div>
                </div>
                <div class="portal-feat">
                    <div class="pf-icon">📂</div>
                    <div>
                        <div class="pf-title">Access shared documents</div>
                        <div class="pf-desc">Contracts, reports, design files — you control which documents each client can
                            access. Clients view and download directly without needing a shared drive link.</div>
                    </div>
                </div>
                <div class="portal-feat">
                    <div class="pf-icon">🔒</div>
                    <div>
                        <div class="pf-title">Granular access control</div>
                        <div class="pf-desc">Set exactly what each customer can see. Restrict document access, limit
                            invoice visibility, or create read-only views — all per-client.</div>
                    </div>
                </div>
            </div>
            <div class="portal-mockup">
                <div class="pm-topbar">
                    <div class="pm-dot"></div>
                    <div class="pm-dot"></div>
                    <div class="pm-dot"></div>
                </div>
                <div class="pm-eyebrow">Client Portal — Blue Harbor LLC</div>
                <div class="pm-card">
                    <div class="pm-card-header">
                        <span class="pm-card-title">Invoice #INV-1041</span>
                        <span class="pm-pill pm-open">Due Apr 5</span>
                    </div>
                    <div class="pm-card-amount">$1,850.00</div>
                    <div class="pm-card-sub">Brand Identity Project · Q1 2026</div>
                    <div class="pm-actions">
                        <div class="pm-pay">Pay now</div>
                        <div class="pm-download">Download</div>
                    </div>
                </div>
                <div class="pm-card pm-card-spaced">
                    <div class="pm-card-header">
                        <span class="pm-card-title">Shared Documents</span>
                        <span class="pm-files-count">3 files</span>
                    </div>
                    <div class="pm-doc-row"><span class="pm-doc-icon">📄</span><span class="pm-doc-name">Service Contract
                            2026.pdf</span><span class="pm-doc-action">View</span></div>
                    <div class="pm-doc-row"><span class="pm-doc-icon">🖼️</span><span class="pm-doc-name">Brand
                            Guidelines v2.pdf</span><span class="pm-doc-action">View</span></div>
                    <div class="pm-doc-row"><span class="pm-doc-icon">📊</span><span class="pm-doc-name">Project Scope
                            Report.pdf</span><span class="pm-doc-action">View</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING -->
    <section id="pricing" class="surface-section">
        <div class="pricing-header">
            <div class="section-label">Pricing</div>
            <h2>Simple, honest <em>pricing</em></h2>
            <p class="section-sub section-sub-centered">No per-invoice fees. No hidden costs. One flat monthly subscription
                — grow your client list without watching a meter tick.</p>
        </div>
        <div class="pricing-grid">
            <div class="plan-card">
                <div class="plan-name">Starter</div>
                <div class="plan-price"><sup>$</sup>29</div>
                <div class="plan-price-period">per month · billed monthly</div>
                <hr class="plan-divider" />
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Up to 25 active clients
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Unlimited invoices & quotes
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Online payment collection
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Customer & items database
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>5 GB document storage
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Client portal (branded)
                </div>
                <a href="{{ route('create-account', ['amount' => 29]) }}" class="plan-btn plan-btn-outline">
                    Get started
                </a>
            </div>
            <div class="plan-card featured">
                <div class="popular-badge">Most popular</div>
                <div class="plan-name">Professional</div>
                <div class="plan-price"><sup>$</sup>79</div>
                <div class="plan-price-period">per month · billed monthly</div>
                <hr class="plan-divider" />
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Unlimited clients
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Unlimited invoices & quotes
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Online payments + auto-reminders
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Full project management
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>50 GB document storage
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Granular portal access controls
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Quote e-signature & approval
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Priority support
                </div>
                <a href="#" class="plan-btn plan-btn-white">Start 14-day trial</a>
            </div>
            <div class="plan-card">
                <div class="plan-name">Agency</div>
                <div class="plan-price"><sup>$</sup>179</div>
                <div class="plan-price-period">per month · billed monthly</div>
                <hr class="plan-divider" />
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Everything in Professional
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>5 team members
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>500 GB document storage
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>White-label client portal domain
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>API access & webhooks
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Custom invoice templates
                </div>
                <div class="plan-feature">
                    <div class="check"><span class="check-icon">✓</span></div>Dedicated account manager
                </div>
                <a href="#" class="plan-btn plan-btn-outline">Contact sales</a>
            </div>
        </div>
        <p class="pricing-note">All plans include a 14-day free trial. No credit card required to start. Annual billing
            saves 20%.</p>
    </section>

    <!-- TESTIMONIALS -->
    <section class="testimonials-section" id="testimonials">
        <div class="testimonials-header">
            <div class="section-label">What customers say</div>
            <h2>Built for <em>real businesses</em></h2>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"Before Velo, invoicing was a nightmare — spreadsheets, email chains, chasing
                    payments for weeks. Now my clients pay within 48 hours because they can do it from their portal. Game
                    changer."</p>
                <div class="testimonial-author">
                    <div class="ta-avatar ta-green">JL</div>
                    <div>
                        <div class="ta-name">Jamie Larkin</div>
                        <div class="ta-role">Freelance Brand Strategist</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"The document sharing feature alone is worth the subscription. I upload
                    contracts and deliverables directly to each client's portal — no more digging through Google Drive
                    folders."</p>
                <div class="testimonial-author">
                    <div class="ta-avatar ta-blue">MR</div>
                    <div>
                        <div class="ta-name">Marcus Reed</div>
                        <div class="ta-role">Principal, Reed Architecture</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"We run 30+ active client projects at any given time. Velo keeps everything
                    organized — quotes convert to invoices, invoices get paid, clients stay informed. I can't imagine going
                    back."</p>
                <div class="testimonial-author">
                    <div class="ta-avatar ta-gold">SK</div>
                    <div>
                        <div class="ta-name">Sarah Kim</div>
                        <div class="ta-role">CEO, Canopy Creative Agency</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="surface-section">
        <div class="text-center-block">
            <div class="section-label">FAQ</div>
            <h2>Common <em>questions</em></h2>
        </div>
        <div class="faq-wrap">
            <div class="faq-item open">
                <div class="faq-q" onclick="toggleFaq(this)">What payment methods can my clients use? <span
                        class="faq-icon">+</span></div>
                <div class="faq-a">Velo uses Stripe to process payments. Your clients can pay using all major credit and
                    debit cards (Visa, Mastercard, Amex), ACH bank transfer, Apple Pay, Google Pay, and any other payment
                    method enabled in your Stripe account. Payouts go directly to your connected bank account.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Can I use my own domain for the client portal? <span
                        class="faq-icon">+</span></div>
                <div class="faq-a">Yes — Agency plan subscribers can map a custom domain (e.g., portal.yourcompany.com) to
                    their Velo client portal. Starter and Professional plans use a branded subdomain on velobiz.com with
                    your business name and logo prominently displayed.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">How does document access control work? <span
                        class="faq-icon">+</span></div>
                <div class="faq-a">You upload documents to your Velo account and then choose which customers can view each
                    file. You can grant or revoke access per-document, per-customer at any time. Clients only see documents
                    you've explicitly shared with them — nothing else in your account is visible.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Can I convert quotes to invoices automatically? <span
                        class="faq-icon">+</span></div>
                <div class="faq-a">Absolutely. When a client approves a quote (via e-signature or portal confirmation),
                    you can convert it to a fully-populated invoice with one click. All line items, taxes, and discounts
                    carry over automatically. You can also set quotes to auto-convert after approval on Professional and
                    Agency plans.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Is there a limit on how many invoices I can send? <span
                        class="faq-icon">+</span></div>
                <div class="faq-a">No. All Velo plans include unlimited invoices and quotes. We don't charge per-document
                    fees or transaction fees on top of Stripe's standard processing rates. Your subscription covers full,
                    unlimited usage.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">What file types can I upload and share with clients? <span
                        class="faq-icon">+</span></div>
                <div class="faq-a">Velo supports PDF, Word documents (DOCX), Excel/CSV, PNG, JPG, and many other common
                    file types. PDFs render inline in the client portal so customers can read documents without downloading.
                    Other formats download directly. Max file size is 250 MB per upload.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Can I cancel anytime? <span class="faq-icon">+</span></div>
                <div class="faq-a">Yes. Velo is month-to-month with no long-term contracts. Cancel any time from your
                    account settings — you'll retain access until the end of your current billing period. Annual subscribers
                    receive a prorated refund on remaining months. You can always export all your data before canceling.
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="section-label section-label-light">Get started today</div>
        <h2>Stop chasing payments.<br><em>Start getting paid.</em></h2>
        <p class="section-sub section-sub-center">Join thousands of freelancers and agencies who trust Velo to run their
            billing and client relationships professionally.</p>
        <div class="cta-actions">
            <a href="#" class="btn btn-accent btn-lg">Start your free trial</a>
            <a href="#" class="btn btn-lg btn-demo">Book a demo ↗</a>
        </div>
        <p class="cta-note">14 days free · No credit card required · Cancel anytime</p>
    </section>

@endsection
