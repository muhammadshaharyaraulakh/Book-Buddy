<?php 
require __DIR__."/../includes/dashboardHeader.php";
?>

<div id="content">
    
    <div class="top-navbar">
        <div class="nav-left">
            <button type="button" id="sidebarCollapse" class="menu-btn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">Dashboard Overview</div>
        </div>
        <div class="nav-right">
            <div class="profile-preview">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <span>Super Admin</span>
            </div>
        </div>
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="icon purple"><i class="fas fa-shopping-bag"></i></div>
            <div class="details"><h3>1,245</h3><small>Total Sales</small></div>
        </div>
        <div class="card">
            <div class="icon orange"><i class="fas fa-book-open"></i></div>
            <div class="details"><h3>856</h3><small>Total Books</small></div>
        </div>
        <div class="card">
            <div class="icon purple"><i class="fas fa-users"></i></div>
            <div class="details"><h3>2,450</h3><small>Customers</small></div>
        </div>
        <div class="card">
            <div class="icon orange"><i class="fas fa-wallet"></i></div>
            <div class="details"><h3>$54k</h3><small>Revenue</small></div>
        </div>
    </div>

    <h3 class="section-heading">Performance Analytics</h3>
    <div class="analytics-grid">
        
        <div class="chart-panel">
            <div class="panel-header">
                <h4>Monthly Orders</h4>
            </div>
            <div class="simple-bar-chart">
                <div class="bar-group">
                    <div class="bar" style="height: 40%;"></div><span>Jan</span>
                </div>
                <div class="bar-group">
                    <div class="bar" style="height: 70%;"></div><span>Feb</span>
                </div>
                <div class="bar-group">
                    <div class="bar active" style="height: 100%;"></div><span>Mar</span>
                </div>
                <div class="bar-group">
                    <div class="bar" style="height: 60%;"></div><span>Apr</span>
                </div>
                <div class="bar-group">
                    <div class="bar" style="height: 80%;"></div><span>May</span>
                </div>
            </div>
        </div>
        
        <div class="chart-panel">
            <div class="panel-header">
                <h4>Sales by Category</h4>
            </div>
            <div class="pie-wrapper">
                <div class="pie-chart">
                    <div class="pie-hole"><span>Total</span></div>
                </div>
                <div class="legend">
                    <div class="legend-item"><span class="dot purple"></span> Fiction (60%)</div>
                    <div class="legend-item"><span class="dot orange"></span> History (25%)</div>
                    <div class="legend-item"><span class="dot grey"></span> Other (15%)</div>
                </div>
            </div>
        </div>

        <div class="chart-panel">
            <div class="panel-header">
                <h4>Monthly Targets</h4>
            </div>
            <div class="progress-list">
                <div class="progress-item">
                    <div class="p-info"><span>Revenue Goal</span> <span>80%</span></div>
                    <div class="progress-bar"><div class="fill purple" style="width: 80%"></div></div>
                </div>
                <div class="progress-item">
                    <div class="p-info"><span>New Users</span> <span>45%</span></div>
                    <div class="progress-bar"><div class="fill orange" style="width: 45%"></div></div>
                </div>
                <div class="progress-item">
                    <div class="p-info"><span>Stock Turnover</span> <span>90%</span></div>
                    <div class="progress-bar"><div class="fill grey" style="width: 90%"></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="analytics-grid two-column" style="margin-top: 20px;">
        
        <div class="chart-panel full-width">
            <div class="panel-header">
                <h4>Revenue Growth (6 Months)</h4>
            </div>
            <div class="svg-chart-container">
                <svg viewBox="0 0 500 150" preserveAspectRatio="none">
                    <line x1="0" y1="150" x2="500" y2="150" stroke="#f0f0f0" stroke-width="2"/>
                    <line x1="0" y1="75" x2="500" y2="75" stroke="#f0f0f0" stroke-width="1"/>
                    
                    <polyline points="0,150 100,100 200,120 300,60 400,90 500,20" 
                              fill="none" stroke="#6c5dd4" stroke-width="3" stroke-linecap="round"/>
                    
                    <polygon points="0,150 100,100 200,120 300,60 400,90 500,20 500,150 0,150" 
                             fill="#6c5dd4" opacity="0.1"/>
                </svg>
                <div class="chart-labels">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                </div>
            </div>
        </div>

        <div class="chart-panel">
            <div class="panel-header">
                <h4>Customer Demographics</h4>
            </div>
            <div class="stacked-bar-container">
                <div class="stacked-group">
                    <small>Age 18-24</small>
                    <div class="stacked-bar">
                        <div class="s-fill purple" style="width: 40%"></div>
                        <div class="s-fill orange" style="width: 60%"></div>
                    </div>
                </div>
                <div class="stacked-group">
                    <small>Age 25-34</small>
                    <div class="stacked-bar">
                        <div class="s-fill purple" style="width: 70%"></div>
                        <div class="s-fill orange" style="width: 30%"></div>
                    </div>
                </div>
                <div class="stacked-group">
                    <small>Age 35+</small>
                    <div class="stacked-bar">
                        <div class="s-fill purple" style="width: 30%"></div>
                        <div class="s-fill orange" style="width: 70%"></div>
                    </div>
                </div>
                <div class="legend-mini">
                    <span><i class="dot purple"></i> Male</span>
                    <span><i class="dot orange"></i> Female</span>
                </div>
            </div>
        </div>

    </div>

</div> </div> <script src="/assests/js/admin.js"></script>
</body>
</html>