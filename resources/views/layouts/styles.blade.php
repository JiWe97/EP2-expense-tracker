<style>
    /* General */
    .link {
        font-weight: 500;
        color: #4a4a4a;
        text-decoration: underline;
        text-decoration-color: #A3BE84;
    }
    .btn {
        border-radius: 0.375rem;
        padding: 0,25 rem 0.5rem;
        text-align: center;      
        font-weight: 500;   
        background-color:#A3BE84;  
        color: #374151;      
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); 
        border-width: 1px;      
        border-color: rgba(55, 65, 81, 0.1); 
        transition: background-color 0.3s; 
    }

    .btn:hover {
        background-color: #f9fafb; 
    }

    .custom-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .custom-error {
        color: red;
        font-size: 0.9rem;
    }

    .custom-mb-4 {
        margin-bottom: 1.5rem;
    }

    .custom-text-center {
        text-align: center;
    }

     .clear-custom-btn, .cancel-custom-btn, .delete-custom-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #b87a9a;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .clear-custom-btn:hover, .cancel-custom-btn:hover, .delete-custom-btn:hover {
        background-color: #ffffff;
        color: #b87a9a;
    }

     .back-link {
        display: inline-block;
        padding: 8px 16px;
        background-color: #7a9ab8;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .back-link:hover {
        background-color: #ffffff;
        color: #7a9ab8;
    }

    .edit-custom-btn, .add-custom-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .edit-custom-btn:hover, .add-custom-btn:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    /* Dashboard */
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
        background-color: #ffffff;
        text-align: center;
        line-height: 40px;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }

    .dashboard-top-right a:hover {
        background-color: #A3BE84;
    }

    /* Dashboard Tables */
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
        background-color: #A3BE84;
        font-weight: bold;
        border-bottom: 2px solid #ddd;
        color: #fff;
    }

    .dashboard-transaction-table tr:nth-child(even), .dashboard-table tr:nth-child(even) {
        background-color: #ffffff;
    }

    .dashboard-transaction-table tr:hover, .dashboard-table tr:hover {
        background-color:#c8d8b6;
    }

    /* Dashboard Cards */
    .dashboard-card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
        padding: 20px;
    }

    /* Dashboard Buttons */
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
        border: 1px solid #A3BE84;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dashboard-btn:hover, .dashboard-btn-primary:hover, .dashboard-btn-danger:hover, .dashboard-btn-secondary:hover {
        background-color: #A3BE84;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .dashboard-btn-primary, .dashboard-btn-danger, .dashboard-btn-secondary {
        background-color: #ffffff;
    }

    .dashboard-btn-primary:hover, .dashboard-btn-secondary:hover {
        background-color: #A3BE84;
    }

    .dashboard-btn-danger:hover {
        background-color: #c82333;
    }

    /* Dashboard Forms */
    .dashboard-form-control {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 1rem;
        font-size: 16px;
        border: 1px solid #A3BE84;
        border-radius: 8px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .dashboard-form-control:focus {
        border-color: #A3BE84;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
    }


    .search-custom-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .search-custom-btn:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    /* Dashboard Pagination */
    .dashboard-pagination {
        display: flex;
        background-color: #ffffff;
        color: #333;
        justify-content: center;
        /*padding: 1rem 0;*/
        margin: 10px
    }

    .dashboard-pagination .page-item {
        margin: 0 5px;
    }

    .dashboard-pagination .page-link {
        color: #333;
        padding: 10px 15px;
        border: 1px solid #A3BE84;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
        background-color: #A3BE84;
    }

    .dashboard-pagination .page-link:hover {
        background-color: #A3BE84;
    }

    /* Dashboard Alerts */
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
        background-color: #A3BE84;
        color: white;
    }

    .dashboard-icon-button {
        font-size: 1.5rem;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #A3BE84;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .dashboard-icon-button:hover {
        background-color: #A3BE84;
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
        
        padding: 10px;
        background-color: white;
        color: #333;
        border: 1px solid #A3BE84;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
        margin:10px;
        align-items: center;
    }

    .search-btn:hover {
        background-color: #A3BE84;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Custom Form */
    .custom-form-control {
        width: 100%;
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .custom-form-control:focus {
        border-color: #A3BE84;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .custom-btn {
        background-color: #A3BE84;
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        color: black;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s;
    }

    .custom-btn:hover {
        background-color: #A3BE84;
    }

    .custom-btn-danger {
        background-color: #A3BE84;
    }

    .custom-btn-danger:hover {
        background-color: #c82333;
    }

    .custom-btn-full {
        width: 100%;
        background-color: #f0f0f0;
    }

    .custom-bg-green-200 {
        background-color: rgba(144, 238, 144, 0.8); /* LightGreen with 80% opacity */
    }

    .custom-btn-income:hover {
        background-color: rgba(144, 238, 144, 1);
    }

    .custom-bg-red-200 {
        background-color: rgba(255, 99, 71, 0.8); /* Tomato with 80% opacity */
    }

    .custom-btn-expense:hover {
        background-color: rgba(255, 99, 71, 1);
    }

    .custom-bg-gray-200 {
        background-color: rgba(211, 211, 211, 0.5); /* LightGray with 50% opacity */
    }

    .custom-form-group {
        margin-bottom: 1rem;
    }

    .custom-form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #333;
    }

    .custom-form-group textarea {
        height: 150px;
    }

    .custom-form-group select {
        height: 50px;
    }

    .btn-custom-show, .btn-danger-show {
        padding: 10px 20px;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        background-color: #A3BE84;
    }

    .btn-custom-show:hover, .btn-danger-show:hover {
        background-color: #2e2e2e;
    }

    .link-custom-show {
        color: #A3BE84;
        text-decoration: underline;
        cursor: pointer;
    }

    .link-custom-show:hover {
        color: #555;
    }

    /* Categories */
    .category-form-error {
        color: red;
        font-size: 0.8rem;
    }

    .category-form-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .category-form-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .category-form-container input[type="text"],
    .category-form-container select {
        width: calc(100% - 24px);
        padding: 12px;
        margin-bottom: 16px;
        border: 1px solid #A3BE84;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .category-form-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .category-form-btn:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .category-form-link {
        color: #A3BE84;
        text-decoration: underline;
        cursor: pointer;
    }

    .category-form-link:hover {
        color: #555;
    }

    .category-list-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .category-list-item:hover {
        background-color: #f5f5f5;
        transform: scale(1.02);
    }

    .category-list-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 12px;
        color: white;
    }

    .category-list-link {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        text-decoration: none;
    }

    .category-list-link.inactive {
        color: #d3d3d3; 
    }

    .category-list-link.inactive:hover {
        color: #a1a1a1;
    }

    .category-list-icon.inactive {
        background-color: #d3d3d3; 
        color: #a1a1a1;
    }

    .category-list-header {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .category-list-add-link {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .category-list-add-link:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .category-list-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

     .category-icon-custom {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }

    .category-icon-custom + .category-icon-custom {
        margin-left: 0.2rem;
    }

     .category-icons-container-custom {
        display: flex;
        overflow-x: auto;
        align-items: center;
        flex-shrink: 0;
    }

    .category-icons-custom {
        display: flex;
        align-items: center;
    }

    .category-icon-show {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 8px;
    }

    /*Category show page*/
    .category-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 12px;
    }

    .hide-custom-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #c8d8b6;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .hide-custom-btn:hover {
        background-color: #ffffff;
        color: #c8d8b6;
    }

    .link-custom {
        color: #333;
        text-decoration: underline;
        cursor: pointer;
    }

    .link-custom:hover {
        color: #555;
    }

    .status-icon {
        font-size: 1.5rem;
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

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .delete-form {
        margin-top: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Budgets */
    .budget-container-wrapper-custom {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
    }

    .budget-item-custom {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1rem;
        border-radius: 0.5rem;
        background-color: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        width: 600px; /* Fixed width for budget items */
        position: relative;
        margin-bottom: 0.5rem; /* Add space between budget items */
    }

    /*Progress bar*/
    .progress-bar-container-custom {
        width: 100%;
        background-color: #e2e8f0;
        border-radius: 0.5rem;
        height: 1rem;
        margin-top: 0.5rem;
        overflow: hidden;
        position: relative;
    }

    .progress-bar-custom {
        background-color: #A3BE84;
        height: 100%;
        border-radius: 0.5rem;
        transition: width 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .progress-text-custom {
        font-size: 0.8rem;
        color: #fff;
        padding: 0 5px;
        z-index: 1;
    }


    .remaining-custom {
        font-size: 0.9rem;
        color: #888;
        text-align: right;
        margin-top: 0.5rem;
    }

    /* Budget header */
    .budget-header-custom {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        width: 100%;
        justify-content: space-between; /* Ensure space between name and icons */
    }

    .budget-name-custom {
        white-space: nowrap;
        overflow: visible;
        text-overflow: ellipsis;
    }

    .budget-details-custom {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .add-budget-link-custom {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .add-budget-link-custom:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .budget-history-link-custom {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .budget-history-link-custom:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .budget-show-container {
        max-width: 800px;
        margin: auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    /*Info message*/
    .info-message-show {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        color: #333;
    }

    .info-message-show i {
        color: #4a4a4a;
    }

    .header-show {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .title-show {
        margin: 0;
    }

    .actions-show {
        display: flex;
        gap: 10px;
    }

    /* Budget form */
    .budget-form-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .budget-form-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .budget-form-container input[type="text"],
    .budget-form-container input[type="number"],
    .budget-form-container input[type="file"],
    .budget-form-container select {
        width: calc(100% - 24px);
        padding: 12px;
        margin-bottom: 16px;
        border: 1px solid #A3BE84;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .budget-form-container input[type="checkbox"] {
        margin-right: 8px;
        vertical-align: middle; /* Aligns the checkbox vertically */
        
    }

    .budget-form-container .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center; /* Aligns the items vertically */
        gap: 10px;
    }

    .budget-form-container .checkbox-group label {
        display: flex;
        align-items: center; /* Aligns checkbox with label text */
        font-weight: normal;
        font-size: 14px;
    }

    .budget-form-container .checkbox-group label input[type="checkbox"] {
        margin-right: 6px;
        appearance: none;
        width: 16px;
        height: 16px;
        border: 1px solid #A3BE84;
        border-radius: 3px;
        outline: none;
        cursor: pointer;
        position: relative;
    }

    .budget-form-container .checkbox-group label input[type="checkbox"]:checked {
        background-color: #A3BE84;
        border-color: #A3BE84;
    }


    .budget-form-container .checkbox-group label input[type="checkbox"]:checked::after {
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

    .budget-form-container .btn-budget {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #A3BE84;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .budget-form-container .btn-budget:hover {
        background-color: #2e2e2e;
    }

    .budget-form-container .link-budget {
        color: #A3BE84;
        text-decoration: underline;
    }

    .budget-form-container .link-budget:hover {
        color: #555;
    }

    .budget-form-container .error-budget {
        color: red;
        font-size: 0.9rem;
    }

    .budget-form-container .alert-budget {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px 15px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-top: 20px;
    }

    .add-budget-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .add-budget-btn:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    /*History*/
    .apply-filter-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .apply-filter-btn:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .history-table th {
        background-color: #A3BE84;
        font-weight: bold;
        color: white;
    }

    /* Goals */
     .goal-container-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
    }

    .goal-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 600px;
        margin-bottom: 20px;
    }

    .goal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .goal-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .goal-amount {
        font-size: 1.2rem;
        color: #888;
    }

    .goal-link {
        color: #A3BE84;
        text-decoration: underline;
        cursor: pointer;
        font-weight: 500;
    }

    .goal-link:hover {
        color: #555;
    }

    .add-goal-link {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .add-goal-link:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .no-goals {
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        color: #333;
        margin-top: 20px;
    }

    /* Goal Detail */
      .goal-detail-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: auto;
            margin-bottom: 20px;
        }

        .goal-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .goal-detail-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .goal-detail-info {
            font-size: 1.2rem;
            color: #888;
        }

        .goal-detail-link {
            color: #A3BE84;
            text-decoration: underline;
            cursor: pointer;
            font-weight: 500;
        }

        .goal-detail-link:hover {
            color: #555;
        }

        .goal-detail-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #A3BE84;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .goal-detail-button:hover {
            background-color: #2e2e2e;
            color: #fff;
        }

        .goal-progress-container {
            margin-bottom: 20px;
        }

    /* Transactions */
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .transaction-table th, .transaction-table td {
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .transaction-table th {
            background-color: #A3BE84;
            font-weight: bold;
            color: white;
        }

        .transaction-table tr:hover {
            background-color: #c8d8b6;
        }
             .progress-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            margin-bottom: 20px;
        }

        .transactions-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .transactions-table th, .transactions-table td {
        padding: 12px 20px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: #333;
    }
    .transactions-table th {
        background-color: #f7f7f7;
        font-weight: bold;
    }
    .transactions-table tr:hover {
        background-color: #A3BE84;
    }


    .transaction-custom-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .transaction-custom-btn:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }

    .transaction-custom-delete-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #b87a9a;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .transaction-custom-delete-btn:hover {
        background-color: #ffffff;
        color: #b87a9a;
    }

        /* Progress Bar */
        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .progress-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .progress-info {
            font-size: 1.2rem;
            color: #888;
        }

        .progress-bar-container {
            width: 100%;
            background-color: #e2e8f0;
            border-radius: 0.5rem;
            height: 1rem;
            margin-top: 0.5rem;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            background-color: #A3BE84; /* Sage green color */
            height: 100%;
            border-radius: 0.5rem;
            transition: width 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .progress-text {
            font-size: 0.8rem;
            color: #fff;
            padding: 0 5px;
            z-index: 1;
        }

        /* Goal Form */
           .goal-form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .goal-form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .goal-form-container input[type="text"],
        .goal-form-container input[type="number"],
        .goal-form-container input[type="file"],
        .goal-form-container select,
        .goal-form-container textarea {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #A3BE84;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .goal-form-container input[type="checkbox"] {
            margin-right: 8px;
            vertical-align: middle; /* Aligns the checkbox vertically */
        }

        .goal-form-container .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center; /* Aligns the items vertically */
            gap: 10px;
        }

        .goal-form-container .checkbox-group label {
            display: flex;
            align-items: center; /* Aligns checkbox with label text */
            font-weight: normal;
            font-size: 14px;
        }

        .goal-form-container .checkbox-group label input[type="checkbox"] {
            margin-right: 6px;
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid #A3BE84;
            border-radius: 3px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .goal-form-container .checkbox-group label input[type="checkbox"]:checked {
            background-color: #A3BE84;
            border-color: #A3BE84;
        }

        .goal-form-container .checkbox-group label input[type="checkbox"]:checked::after {
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

        .goal-form-container .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #A3BE84;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .goal-form-container .btn:hover {
            background-color: #2e2e2e;
        }

        .goal-form-container .link {
            color: #A3BE84;
            text-decoration: underline;
        }

        .goal-form-container .link:hover {
            color: #555;
        }

        .goal-form-container .error {
            color: red;
            font-size: 0.9rem;
        }

        .goal-form-container .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .form-container-custom {
        max-width: 800px;
        margin: 2rem auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .form-group-custom {
        margin-bottom: 1.5rem;
    }
    .form-group-custom label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #333;
    }
    .form-group-custom input {
        width: calc(100% - 24px);
        padding: 12px;
        border: 1px solid #A3BE84;
        border-radius: 8px;
        font-size: 1rem;
        box-sizing: border-box;
    }
    .form-group-custom input:focus {
        border-color: #A3BE84;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(163, 190, 132, 0.25);
    }

    /* Add custom styles for the button */
    .btn-custom-form {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #A3BE84;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-custom-form:hover {
        background-color: #2e2e2e;
    }
    .link-custom-form {
        color: #A3BE84;
        text-decoration: underline;
        cursor: pointer;
    }
    .link-custom-form:hover {
        color: #555;
    }
    .error-custom {
        color: red;
        font-size: 0.9rem;
    }

    /*Payoff*/
        .payoff-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .payoff-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .payoff-header h1 {
        font-size: 2rem;
        font-weight: bold;
    }
    .payoff-stats {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .payoff-stats h4 {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }

    .add-payoff-link-custom {
        display: inline-block;
        padding: 8px 16px;
        background-color: #A3BE84;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .add-payoff-link-custom:hover {
        background-color: #ffffff;
        color: #A3BE84;
    }
    
    .btn-custom-payoff {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #A3BE84;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-custom-payoff:hover {
        background-color: #2e2e2e;
    }
</style>
