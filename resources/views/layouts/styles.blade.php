<style>
    .btn {
        @apply rounded-md px-2 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50;
    }
    .link {
        @apply font-medium text-gray-700 underline decoration-pink-500;
    }
    label {
        @apply block uppercase text-slate-700 mb-2;
    }
    input, textarea {
        @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none;
    }
    .form-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .form-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="file"],
    .form-container select {
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

    .form-container .btn {
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

    .form-container .btn:hover {
        background-color: #2e2e2e;
    }

    .form-container .link {
        color: #333;
        text-decoration: underline;
        cursor: pointer;
    }

    .form-container .link:hover {
        color: #555;
    }

    .form-container .error,
    .error {
        color: red;
        font-size: 0.9rem;
    }

    .form-container .alert {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px 15px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-top: 20px;
    }

    .category-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 12px;
    }

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

    .btn-custom,
    .btn-danger {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4a4a4a;
        color: white;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-custom:hover,
    .btn-danger:hover {
        background-color: #2e2e2e;
    }

    .link-custom {
        color: #333;
        text-decoration: underline;
        cursor: pointer;
    }

    .link-custom:hover {
        color: #555;
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

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
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
        background-color: rgba(0, 0, 0, 0.4);
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
</style>
