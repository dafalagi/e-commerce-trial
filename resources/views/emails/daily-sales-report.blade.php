<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            margin-bottom: 25px;
            font-size: 16px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        .summary-card h3 {
            margin: 0 0 10px 0;
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #495057;
        }
        .summary-card .currency {
            color: #28a745;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #495057;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        .table tr:hover {
            background: #f8f9fa;
        }
        .currency {
            color: #28a745;
            font-weight: 600;
        }
        .low-stock {
            color: #dc3545;
            font-weight: 600;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #dee2e6;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px;
            }
            .summary-grid {
                grid-template-columns: 1fr;
            }
            .table {
                font-size: 14px;
            }
            .table th, .table td {
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 Daily Sales Report</h1>
            <p>{{ $report_date->format('l, F j, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                <p>Hello <strong>{{ $admin_user->email }}</strong>,</p>
                <p>Here's your daily sales summary for {{ $report_date->format('F j, Y') }}:</p>
            </div>

            <!-- Summary Cards -->
            <div class="summary-grid">
                <div class="summary-card">
                    <h3>Total Orders</h3>
                    <div class="value">{{ number_format($sales_data['summary']['total_orders']) }}</div>
                </div>
                <div class="summary-card">
                    <h3>Total Revenue</h3>
                    <div class="value currency">${{ number_format($sales_data['summary']['total_revenue'], 2) }}</div>
                </div>
                <div class="summary-card">
                    <h3>Items Sold</h3>
                    <div class="value">{{ number_format($sales_data['summary']['total_items_sold']) }}</div>
                </div>
                <div class="summary-card">
                    <h3>Avg. Order Value</h3>
                    <div class="value currency">${{ number_format($sales_data['summary']['average_order_value'], 2) }}</div>
                </div>
            </div>

            @if($sales_data['summary']['total_orders'] > 0)
                <!-- Top Selling Products -->
                <div class="section">
                    <h2>🏆 Top Selling Products</h2>
                    @if($sales_data['top_products']->isNotEmpty())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="text-align: right;">Qty Sold</th>
                                    <th style="text-align: right;">Revenue</th>
                                    <th style="text-align: right;">Stock Left</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales_data['top_products'] as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td style="text-align: right;">{{ number_format($product['quantity_sold']) }}</td>
                                    <td style="text-align: right;" class="currency">${{ number_format($product['revenue'], 2) }}</td>
                                    <td style="text-align: right;" class="{{ $product['current_stock'] < 10 ? 'low-stock' : '' }}">
                                        {{ number_format($product['current_stock']) }}
                                        @if($product['current_stock'] < 10)
                                            ⚠️
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no-data">No product sales data available for this date.</div>
                    @endif
                </div>

                @if($sales_data['low_stock_products']->isNotEmpty())
                    <!-- Low Stock Alert -->
                    <div class="section">
                        <h2>⚠️ Low Stock Alert</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="text-align: right;">Current Stock</th>
                                    <th style="text-align: right;">Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales_data['low_stock_products'] as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td style="text-align: right;" class="low-stock">{{ $product->stock }}</td>
                                    <td style="text-align: right;" class="currency">${{ number_format($product->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="no-data">
                    <h3>No Sales Data</h3>
                    <p>There were no orders placed on {{ $report_date->format('F j, Y') }}.</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This report was automatically generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>E-Commerce System</strong> - Daily Sales Analytics</p>
        </div>
    </div>
</body>
</html>