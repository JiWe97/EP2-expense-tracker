<style>
    /* DASHBOARD */
    body html {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #333;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
    }
    .link {
    font-weight: 500;
    color: #4a4a4a;
    text-decoration: underline;
    text-decoration-color: #A3BE84;
    }


    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #ffffff;
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
        background-color: #ffffff;
        text-align: center;
        line-height: 40px;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }

    .dashboard-top-right a:hover {
        background-color: #A3BE84;
    }
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
        background-color: #ffffff;
        font-weight: bold;
        border-bottom: 2px solid #ddd;
    }
    .dashboard-transaction-table tr:nth-child(even), .dashboard-table tr:nth-child(even) {
        background-color: #ffffff;
    }
    .dashboard-transaction-table tr:hover, .dashboard-table tr:hover {
        background-color: #A3BE84;
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
        border: 1px solid #A3BE84;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .dashboard-btn:hover, .dashboard-btn-primary:hover, .dashboard-btn-danger:hover, .dashboard-btn-secondary:hover {
        background-color: #A3BE84;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .dashboard-btn-primary {
        background-color: #ffffff;
    }
    .dashboard-btn-danger {
        background-color: #ffffff;
    }
    .dashboard-btn-secondary {
        background-color: #ffffff;
    }
    .dashboard-btn-primary:hover {
        background-color: #A3BE84;
    }
    .dashboard-btn-danger:hover {
        background-color: #c82333;
    }
    .dashboard-btn-secondary:hover {
        background-color: #A3BE84;
    }

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
        border: 1px solid #A3BE84;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .dashboard-pagination .page-link:hover {
        background-color: #A3BE84;
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
        background-color: #A3BE84;
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
        display: inline-flex;
        justify-content: flex-end;
        padding: 10px;
        background-color: white;
        color: #333;
        border: 1px solid #A3BE84;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }
    .search-btn:hover {
        background-color: #A3BE84;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
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

    .custom-mb-4 {
        margin-bottom: 1.5rem;
    }

    .custom-error {
        color: red;
        font-size: 0.9rem;
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

    



    /* CATEGORIES */
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

    .category-form-btn:hover {
        background-color: #A3BE84;
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



</style>