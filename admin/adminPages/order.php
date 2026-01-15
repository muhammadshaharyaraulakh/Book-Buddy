<?php 
require __DIR__."/../../config/config.php";
require __DIR__."/../../includes/dashboardHeader.php";
?>
<div id="content">
            <div class="top-navbar">
                <button type="button" id="sidebarCollapse" class="menu-btn"><i class="fas fa-bars"></i></button>
                <div class="page-title">Pending Orders</div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-991</td>
                            <td>Sarah Connor</td>
                            <td>$45.00</td>
                            <td><span style="color:var(--orange); font-weight:600;">Pending</span></td>
                            <td>
                                <button class="btn btn-primary">Complete</button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ORD-992</td>
                            <td>John Wick</td>
                            <td>$120.00</td>
                            <td><span style="color:var(--orange); font-weight:600;">Pending</span></td>
                            <td>
                                <button class="btn btn-primary">Complete</button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>