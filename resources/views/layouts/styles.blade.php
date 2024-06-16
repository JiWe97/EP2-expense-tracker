<style>
    /* Base Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .text-center {
        text-align: center;
    }

    /* Button Styles */
    .btn, .btn-custom, .btn-danger, .form-container .btn {
        @apply rounded-md px-2 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50;
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4a4a4a;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover, .btn-custom:hover, .btn-danger:hover, .form-container .btn:hover {
        background-color: #2e2e2e;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-full {
        width: 100%;
        background-color: #f0f0f0;
    }

    /* Link Styles */
    .link, .form-container .link, .link-custom {
        @apply font-medium text-gray-700 underline decoration-pink-500;
        color: #333;
        text-decoration: underline;
        cursor: pointer;
    }

    .link:hover, .form-container .link:hover, .link-custom:hover {
        color: #555;
    }

    /* Form Styles */
    .form-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .form-container label, label {
        @apply block uppercase text-slate-700 mb-2;
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="file"],
    .form-container select,
    input, textarea {
        @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none;
        width: calc(100% - 24px);
        padding: 12px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .form-container input[type="checkbox"] {
        margin-right: 8px;
        vertical-align: middle;
    }

    .form-container .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .form-container .checkbox-group label {
        display: flex;
        align-items: center;
        font-weight: normal;
        font-size: 14px;
    }

    .form-container .checkbox-group label input[type="checkbox"] {
        margin-right: 6px;
        appearance: none;
        width: 16px;
        height: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
        outline: none;
        cursor: pointer;
        position: relative;
    }

    .form-container .checkbox-group label input[type="checkbox"]:checked {
        background-color: #333;
        border-color: #333;
    }

    .form-container .checkbox-group label input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 5px;
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 1rem;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #333;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
    }

    .form-container .error, .error {
        color: red;
        font-size: 0.9rem;
    }

    .form-container .alert, .alert {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px 15px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-top: 20px;
    }

    /* Category Styles */
    .category-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 12px;
    }

    .category-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .category-item:hover {
        background-color: #f5f5f5;
        transform: scale(1.02);
    }

    .category-link {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        text-decoration: none;
    }

    .category-link.inactive {
        color: #d3d3d3;
    }

    .category-link.inactive:hover {
        color: #a1a1a1;
    }

    .category-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .category-name {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .income-expense-tag {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .income-tag {
        background-color: #e0f7fa;
        color: #00796b;
    }

    .expense-tag {
        background-color: #ffebee;
        color: #c62828;
    }

    /* Utility Classes */
    .info-message {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        color: #333;
    }

    .info-message i {
        color: #4a4a4a;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        font-weight: 600;
    }

    .title {
        margin: 0;
    }

    .actions {
        display: flex;
        gap: 10px;
    }

    .status-icon {
        font-size: 1.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .delete-form {
        margin-top: 10px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    /* Table Styles */
    .table, .transaction-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #e0e0e0;
    }

    .transaction-table {
        margin-top: 20px;
        background-color: white;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .transaction-table th, .transaction-table td {
        border: none;
        padding: 12px 15px;
    }

    .transaction-table th {
        background-color: #f7f7f7;
        font-weight: bold;
        color: #333;
    }

    .transaction-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .transaction-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 1rem 0;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-link {
        color: #333;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .pagination .page-link:hover {
        background-color: #f1f1f1;
    }

    /* Modal Styles */
    .modal {
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

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        width: 80%;
        max-width: 500px;
        margin: auto;
    }

    .modal img {
        max-width: 100%;
        height: auto;
    }

    .modal:target {
        display: flex;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        color: #aaa;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Alert Styles */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

    .alert-warning {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border-color: #faebcc;
    }

    /* Additional Form Control Styles */
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Specific Button Styles */
    .btn-income:hover {
        background-color: rgba(144, 238, 144, 1);
    }

    .btn-expense:hover {
        background-color: rgba(255, 99, 71, 1);
    }

    .bg-green-200 {
        background-color: rgba(144, 238, 144, 0.8); /* LightGreen with 80% opacity */
    }

    .bg-red-200 {
        background-color: rgba(255, 99, 71, 0.8); /* Tomato with 80% opacity */
    }

    .bg-gray-200 {
        background-color: rgba(211, 211, 211, 0.5); /* LightGray with 50% opacity */
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #333;
    }

    .form-group textarea {
        height: 150px;
    }

    .form-group select {
        height: 50px;
    }
</style>
