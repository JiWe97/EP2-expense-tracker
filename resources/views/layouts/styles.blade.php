<style>
    .btn {
            @apply rounded-md px-2 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50
    }
    .link {
        @apply font-medium text-gray-700 underline decoration-pink-500
    }
    label {
        @apply block uppercase text-slate-700 mb-2
    }
    input, textarea {
        @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
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
        background-color: #333;
        color: white;
        text-align: center;
        text-decoration: none;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-container .btn:hover {
        background-color: #555;
    }

    .form-container .link {
        color: #333;
        text-decoration: underline;
    }

    .form-container .link:hover {
        color: #555;
    }

    .form-container .error {
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
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 8px;
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

    .btn-custom, .btn-danger {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4a4a4a;
        color: white;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-custom:hover, .btn-danger:hover {
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
    }

    .title {
        margin: 0;
    }

    .actions {
        display: flex;
        gap: 10px;
    }

</style>
