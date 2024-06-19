<style>
body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .dashboard-header h1 {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .dashboard-top-right a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #f0f0f0;
        text-align: center;
        line-height: 40px;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }

    .dashboard-top-right a:hover {
        background-color: #e0e0e0;
    }
    /* Custom Styles for Dashboard */
    .dashboard-transaction-table, .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border: 1px solid #ddd;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .dashboard-transaction-table th, .dashboard-transaction-table td, .dashboard-table th, .dashboard-table td {
        padding: 12px 20px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: #333;
    }
    .dashboard-transaction-table th, .dashboard-table th {
        background-color: #f7f7f7;
        font-weight: bold;
        border-bottom: 2px solid #ddd;
    }
    .dashboard-transaction-table tr:nth-child(even), .dashboard-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .dashboard-transaction-table tr:hover, .dashboard-table tr:hover {
        background-color: #f1f1f1;
    }

    .dashboard-card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
        padding: 20px;
    }

    .dashboard-btn, .dashboard-btn-primary, .dashboard-btn-danger, .dashboard-btn-secondary {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
        color: #333;
        width: 25%;
        border: 1px solid #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .dashboard-btn:hover, .dashboard-btn-primary:hover, .dashboard-btn-danger:hover, .dashboard-btn-secondary:hover {
        background-color: #555;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .dashboard-btn-primary {
        background-color: grey;
    }
    .dashboard-btn-danger {
        background-color: #dc3545;
    }
    .dashboard-btn-secondary {
        background-color: #6c757d;
    }
    .dashboard-btn-primary:hover {
        background-color: #5a6268;
    }
    .dashboard-btn-danger:hover {
        background-color: #c82333;
    }
    .dashboard-btn-secondary:hover {
        background-color: #5a6268;
    }

    .dashboard-form-control {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 1rem;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .dashboard-form-control:focus {
        border-color: #333;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
    }

    .dashboard-mb-4 {
        margin-bottom: 1.5rem;
    }
    .dashboard-text-center {
        text-align: center;
    }
    .dashboard-pagination {
        display: flex;
        justify-content: center;
        padding: 1rem 0;
    }
    .dashboard-pagination .page-item {
        margin: 0 5px;
    }
    .dashboard-pagination .page-link {
        color: #333;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .dashboard-pagination .page-link:hover {
        background-color: #f1f1f1;
    }
    .dashboard-alert {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px 15px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-top: 20px;
    }
    .dashboard-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
    }
    .dashboard-modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        width: 80%;
        max-width: 500px;
        margin: auto;
    }
    .dashboard-modal img {
        max-width: 100%;
        height: auto;
    }
    .dashboard-modal:target {
        display: flex;
    }
    .dashboard-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
    }
    .dashboard-selected {
        background-color: #4CAF50;
        color: white;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .dashboard-icon-button {
        font-size: 1.5rem;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, box-shadow 0.3s;
    }
    .dashboard-icon-button:hover {
        background-color: #555;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .dashboard-search-form {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }
    .search-btn {
        display: inline-flex;
        justify-content: flex-end;
        padding: 10px;
        background-color: white;
        color: #333;
        border: 1px solid #333;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }
    .search-btn:hover {
        background-color: #555;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>