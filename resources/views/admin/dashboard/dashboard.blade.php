  @extends('layouts.admin')

  @section('title', 'Velo — Dashboard')

  @section('content')
      <!-- Main -->
      <main class="main">

          <!-- Greeting -->
          <div class="greeting-row">
              <div class="greeting-text">
                  <h1>Good morning, Sarah ☀️</h1>
                  <p>Tuesday, April 7, 2026 · Here's what's happening with your business today.</p>
              </div>
              <div class="greeting-actions">
                  <button class="btn-secondary" onclick="toast('Quote draft created!')">+ New Quote</button>
                  <button class="btn-new-invoice" onclick="window.location.href='{{ route('subscriber.invoices.create') }}'">＋ New
                      Invoice</button>
              </div>
          </div>

          <!-- KPIs -->
          <div class="kpi-grid">
              <div class="kpi-card">
                  <div class="kpi-header">
                      <span class="kpi-label">Total Revenue</span>
                      <div class="kpi-icon icon-teal">💰</div>
                  </div>
                  <div class="kpi-value">$84,320</div>
                  <div class="kpi-change up">↑ 14% this month</div>
              </div>
              <div class="kpi-card">
                  <div class="kpi-header">
                      <span class="kpi-label">Outstanding</span>
                      <div class="kpi-icon icon-amber">⏳</div>
                  </div>
                  <div class="kpi-value">$12,450</div>
                  <div class="kpi-change down">↓ 8 invoices due</div>
              </div>
              <div class="kpi-card">
                  <div class="kpi-header">
                      <span class="kpi-label">Quotes Sent</span>
                      <div class="kpi-icon icon-slate">📄</div>
                  </div>
                  <div class="kpi-value">23</div>
                  <div class="kpi-change up">↑ 3 this week</div>
              </div>
              <div class="kpi-card">
                  <div class="kpi-header">
                      <span class="kpi-label">Active Clients</span>
                      <div class="kpi-icon icon-teal">👥</div>
                  </div>
                  <div class="kpi-value">47</div>
                  <div class="kpi-change up">↑ 5 new this month</div>
              </div>
          </div>

          <!-- Mid row: chart + activity -->
          <div class="mid-row">

              <!-- Revenue Chart -->
              <div class="card chart-card">
                  <div class="card-head">
                      <span class="card-title">Revenue — Last 6 Months</span>
                      <a class="card-action">View Report →</a>
                  </div>
                  <div class="chart-area">
                      <div class="chart-bars">
                          <div class="chart-col">
                              <div class="bar-val">$9.2k</div>
                              <div class="bar muted bar-h-52"></div>
                              <div class="bar-label">Nov</div>
                          </div>
                          <div class="chart-col">
                              <div class="bar-val">$11.8k</div>
                              <div class="bar muted bar-h-67"></div>
                              <div class="bar-label">Dec</div>
                          </div>
                          <div class="chart-col">
                              <div class="bar-val">$13.1k</div>
                              <div class="bar muted bar-h-74"></div>
                              <div class="bar-label">Jan</div>
                          </div>
                          <div class="chart-col">
                              <div class="bar-val">$10.5k</div>
                              <div class="bar muted bar-h-59"></div>
                              <div class="bar-label">Feb</div>
                          </div>
                          <div class="chart-col">
                              <div class="bar-val">$15.6k</div>
                              <div class="bar muted bar-h-88"></div>
                              <div class="bar-label">Mar</div>
                          </div>
                          <div class="chart-col">
                              <div class="bar-val">$17.2k</div>
                              <div class="bar bar-h-97"></div>
                              <div class="bar-label">Apr</div>
                          </div>
                      </div>
                      <div class="chart-legend">
                          <div class="legend-item">
                              <div class="legend-dot legend-current"></div>
                              Current month
                          </div>
                          <div class="legend-item">
                              <div class="legend-dot legend-previous"></div>
                              Previous months
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Activity Feed -->
              <div class="card activity-card">
                  <div class="card-head">
                      <span class="card-title">Recent Activity</span>
                      <a class="card-action">View all →</a>
                  </div>
                  <div class="activity-list">
                      <div class="activity-item">
                          <div class="act-icon icon-teal">💳</div>
                          <div class="act-body">
                              <div class="act-text"><strong>Acme Corp</strong> paid invoice INV-0091</div>
                              <div class="act-time">2 minutes ago</div>
                          </div>
                      </div>
                      <div class="activity-item">
                          <div class="act-icon icon-amber">📄</div>
                          <div class="act-body">
                              <div class="act-text">Quote <strong>QUO-0047</strong> viewed by TechNova Ltd</div>
                              <div class="act-time">1 hour ago</div>
                          </div>
                      </div>
                      <div class="activity-item">
                          <div class="act-icon icon-teal">👥</div>
                          <div class="act-body">
                              <div class="act-text">New client <strong>Sunrise Media</strong> added</div>
                              <div class="act-time">3 hours ago</div>
                          </div>
                      </div>
                      <div class="activity-item">
                          <div class="act-icon icon-red">⏰</div>
                          <div class="act-body">
                              <div class="act-text">Invoice <strong>INV-0089</strong> is overdue (7 days)</div>
                              <div class="act-time">Yesterday</div>
                          </div>
                      </div>
                      <div class="activity-item">
                          <div class="act-icon icon-slate">📎</div>
                          <div class="act-body">
                              <div class="act-text">Document <strong>Contract-2026.pdf</strong> shared</div>
                              <div class="act-time">2 days ago</div>
                          </div>
                      </div>
                  </div>
              </div>

          </div>

          <!-- Bottom row: invoices + tasks -->
          <div class="bottom-row">

              <!-- Recent Invoices -->
              <div class="card invoices-card">
                  <div class="card-head">
                      <span class="card-title">Recent Invoices</span>
                      <a class="card-action">View all →</a>
                  </div>
                  <div class="table-wrap">
                      <table>
                          <thead>
                              <tr>
                                  <th>Client</th>
                                  <th>Amount</th>
                                  <th>Due</th>
                                  <th>Status</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>
                                      <div class="inv-client">Acme Corp</div>
                                      <div class="inv-num">INV-0091</div>
                                  </td>
                                  <td><span class="inv-amount">$3,200</span></td>
                                  <td><span class="inv-due">Apr 1</span></td>
                                  <td><span class="badge badge-paid">Paid</span></td>
                              </tr>
                              <tr>
                                  <td>
                                      <div class="inv-client">TechNova Ltd</div>
                                      <div class="inv-num">INV-0092</div>
                                  </td>
                                  <td><span class="inv-amount">$7,850</span></td>
                                  <td><span class="inv-due">Apr 10</span></td>
                                  <td><span class="badge badge-pending">Pending</span></td>
                              </tr>
                              <tr>
                                  <td>
                                      <div class="inv-client">Sunrise Media</div>
                                      <div class="inv-num">INV-0089</div>
                                  </td>
                                  <td><span class="inv-amount">$1,540</span></td>
                                  <td><span class="inv-due">Mar 31</span></td>
                                  <td><span class="badge badge-overdue">Overdue</span></td>
                              </tr>
                              <tr>
                                  <td>
                                      <div class="inv-client">Pixel Studio</div>
                                      <div class="inv-num">INV-0090</div>
                                  </td>
                                  <td><span class="inv-amount">$4,100</span></td>
                                  <td><span class="inv-due">Apr 15</span></td>
                                  <td><span class="badge badge-pending">Pending</span></td>
                              </tr>
                              <tr>
                                  <td>
                                      <div class="inv-client">Green Valley Co</div>
                                      <div class="inv-num">INV-0088</div>
                                  </td>
                                  <td><span class="inv-amount">$920</span></td>
                                  <td><span class="inv-due">Mar 20</span></td>
                                  <td><span class="badge badge-draft">Draft</span></td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>

              <!-- Quick Tasks -->
              <div class="card tasks-card">
                  <div class="card-head">
                      <span class="card-title">Quick Tasks</span>
                      <a class="card-action">Add task →</a>
                  </div>
                  <div class="task-list">
                      <div class="task-item task-done" onclick="toggleTask(this)">
                          <div class="task-check">✓</div>
                          <span class="task-text">Send invoice to Acme Corp</span>
                          <span class="task-tag tag-invoice">Invoice</span>
                      </div>
                      <div class="task-item" onclick="toggleTask(this)">
                          <div class="task-check">✓</div>
                          <span class="task-text">Follow up on overdue INV-0089</span>
                          <span class="task-tag tag-invoice">Invoice</span>
                      </div>
                      <div class="task-item" onclick="toggleTask(this)">
                          <div class="task-check">✓</div>
                          <span class="task-text">Prepare quote for Sunrise Media</span>
                          <span class="task-tag tag-quote">Quote</span>
                      </div>
                      <div class="task-item" onclick="toggleTask(this)">
                          <div class="task-check">✓</div>
                          <span class="task-text">Add new Pixel Studio contact</span>
                          <span class="task-tag tag-client">Client</span>
                      </div>
                      <div class="task-item" onclick="toggleTask(this)">
                          <div class="task-check">✓</div>
                          <span class="task-text">Upload March contracts to portal</span>
                          <span class="task-tag tag-client">Docs</span>
                      </div>
                      <div class="task-item" onclick="toggleTask(this)">
                          <div class="task-check">✓</div>
                          <span class="task-text">Review Q1 revenue report</span>
                          <span class="task-tag tag-quote">Report</span>
                      </div>
                  </div>
              </div>

          </div>
      </main>

  @endsection
