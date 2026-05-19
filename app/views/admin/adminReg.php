<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Outfit:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Colors */
            --white: #ffffff;
            --off: #f8f5f2;
            --surface: #f2ede8;
            --red: #c8102e;
            --red-dk: #9b0b21;
            --red-lt: #fbeaec;
            --red-m: #f5c0c7;
            --amber: #d97706;
            --green: #15803d;
            --blue: #1d4ed8;
            --slate: #475569;
            --text: #1a1a1a;
            --muted: #6b6b6b;
            --border: #e2ddd8;
            
            /* Typography */
            --font-hd: 'Playfair Display', serif;
            --font-bd: 'Outfit', sans-serif;
            --font-mn: 'JetBrains Mono', monospace;
            
            /* Effects */
            --shadow: 0 4px 12px rgba(0,0,0,0.05);
            --radius-lg: 20px;
            --radius-md: 14px;
        }

    
        body {
            background: linear-gradient(135deg, var(--off) 0%, #f5f1ed 100%);
            font-family: var(--font-bd);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }


        .registration-wrapper {
            width: 100%;
            max-width: 1000px;
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            padding: 2.5rem;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }


        .form-header {
            text-align: center;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .back-btn-wrapper {
            position: absolute;
            top: 0;
            left: 0;
        }

        .back-btn {
            background: transparent;
            border: 1.5px solid var(--border);
            color: var(--text);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            font-size: 0.8rem;
            font-family: var(--font-bd);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .back-btn:hover {
            background: var(--surface);
            border-color: var(--red);
            color: var(--red);
        }

        .form-header h1 {
            font-family: var(--font-hd);
            font-size: 1.8rem;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .form-header p {
            font-size: 0.9rem;
            color: var(--muted);
            font-weight: 400;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--red-lt), transparent);
            margin: 0.5rem 0 1rem 0;
        }

    
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
        }

        .form-row .form-group {
            grid-column: span 1;
        }


        label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: var(--font-mn);
        }

        input, select {
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            background: var(--white);
            font-family: var(--font-bd);
            font-size: 0.95rem;
            color: var(--text);
            transition: all 0.2s ease;
        }

        input::placeholder {
            color: var(--muted);
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--red);
            box-shadow: 0 0 0 3px var(--red-lt);
            background: var(--white);
        }

        input:hover, select:hover {
            border-color: var(--red-m);
        }

    
        .form-actions {
            display: flex;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        button {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-family: var(--font-bd);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--red) 0%, var(--red-dk) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(200, 16, 46, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(200, 16, 46, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text);
            border: 1.5px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--off);
            border-color: var(--muted);
        }

    
        .error-message {
            font-size: 0.75rem;
            color: var(--red);
            font-weight: 500;
            display: none;
            margin-top: 0.3rem;
        }

        .form-group.error input,
        .form-group.error select {
            border-color: var(--red);
            background: rgba(200, 16, 46, 0.02);
        }

        .form-group.error .error-message {
            display: block;
        }

        .form-group.success input,
        .form-group.success select {
            border-color: var(--green);
            background: rgba(21, 128, 61, 0.02);
        }


        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: #1e293b;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            margin-bottom: 0.8rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideInRight 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.9rem;
        }

        .toast.success {
            background: var(--green);
        }

        .toast.error {
            background: var(--red);
        }

        .toast.warning {
            background: var(--amber);
            color: white;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }


        @media (max-width: 600px) {
            .registration-wrapper {
                padding: 1.5rem;
            }

            .form-header h1 {
                font-size: 1.4rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            button {
                width: 100%;
            }

            .toast-container {
                left: 20px;
                right: 20px;
            }

            .toast {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="registration-wrapper">
        <form id="adminRegForm">
            <div class="form-header">
                <div class="back-btn-wrapper">
                    <a href="../../../app/controllers/admin.php" class="back-btn">← Back</a>
                </div>
                <h1>Create New Admin</h1>
                <div class="divider"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="fname" id="fname" placeholder="Enter first name">
                    <div class="error-message" id="fnameError"></div>
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" id="lname" placeholder="Enter last name">
                    <div class="error-message" id="lnameError"></div>
                </div>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="username" placeholder="Enter username">
                <div class="error-message" id="usernameError"></div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email address">
                <div class="error-message" id="emailError"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" id="gender">
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <div class="error-message" id="genderError"></div>
                </div>
                
                <div class="form-group">
                    <label>Age</label>
                    <input type="text" name="age" id="age" placeholder="Enter age">
                    <div class="error-message" id="ageError"></div>
                </div>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="tel" name="cnumber" id="cnumber" placeholder="Enter contact number">
                <div class="error-message" id="cnumberError"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password">
                    <div class="error-message" id="passwordError"></div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                    <div class="error-message" id="confirm_passwordError"></div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Register Admin</button>
                <button type="reset" class="btn-secondary">Clear Form</button>
            </div>
        </form>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>

        const form = document.getElementById('adminRegForm');
        const formInputs = {
            fname: document.getElementById('fname'),
            lname: document.getElementById('lname'),
            username: document.getElementById('username'),
            gender: document.getElementById('gender'),
            age: document.getElementById('age'),
            email: document.getElementById('email'),
            cnumber: document.getElementById('cnumber'),
            password: document.getElementById('password'),
            confirm_password: document.getElementById('confirm_password')
        };

        const validationRules = {
            fname: {
                validate: (value) => value.trim().length >= 2,
                error: 'Invalid First Name'
            },
            lname: {
                validate: (value) => value.trim().length >= 2,
                error: 'Invalid Last Name '
            },
            username: {
                validate: (value) => {
                    // Username must be 3-20 characters, alphanumeric and underscore only
                    const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
                    return usernameRegex.test(value.trim());
                },
                error: 'Username must be 3-20 characters (letters, numbers, underscore only)'
            },
            gender: {
                validate: (value) => value !== '',
                error: 'Please select a gender'
            },
            age: {
                validate: (value) => {
                    const age = parseInt(value);
                    return age >= 18 && age <= 120;
                },
                error: 'Invalid Age'
            },
            email: {
                validate: (value) => {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value);
                },
                error: 'Please enter a valid email address'
            },
            cnumber: {
                validate: (value) => {
                    const phoneRegex = /^[0-9\-\+\(\)\s]{10,}$/;
                    return phoneRegex.test(value.replace(/\s/g, ''));
                },
                error: 'Please enter a valid contact number (minimum 10 digits)'
            },
            password: {
                validate: (value) => value.trim().length >= 1,
                error: 'Password is required'
            },
            confirm_password: {
                validate: (value) => {
                    return value === formInputs.password.value;
                },
                error: 'Passwords do not match'
            }
        };


        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const iconMap = {
                success: '✓',
                error: '✕',
                warning: '⚠'
            };

            toast.innerHTML = `${iconMap[type]} ${message}`;
            toastContainer.appendChild(toast);

   
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOutRight {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100px);
                }
            }
        `;
        document.head.appendChild(style);

        function validateField(fieldName) {
            const input = formInputs[fieldName];
            const rule = validationRules[fieldName];
            const formGroup = input.closest('.form-group');
            const errorElement = document.getElementById(`${fieldName}Error`);

            if (!rule.validate(input.value)) {
                formGroup.classList.remove('success');
                formGroup.classList.add('error');
                errorElement.textContent = rule.error;
                return false;
            } else {
                formGroup.classList.remove('error');
                formGroup.classList.add('success');
                errorElement.textContent = '';
                return true;
            }
        }

        function validateForm() {
            let isValid = true;
            for (const fieldName in formInputs) {
                if (!validateField(fieldName)) {
                    isValid = false;
                }
            }
            return isValid;
        }

        function clearValidationStates() {
            for (const fieldName in formInputs) {
                const formGroup = formInputs[fieldName].closest('.form-group');
                const errorElement = document.getElementById(`${fieldName}Error`);
                formGroup.classList.remove('error', 'success');
                errorElement.textContent = '';
            }
        }

        for (const fieldName in formInputs) {
            formInputs[fieldName].addEventListener('blur', () => {
                validateField(fieldName);
            });


            formInputs[fieldName].addEventListener('input', () => {
                const formGroup = formInputs[fieldName].closest('.form-group');
                if (formGroup.classList.contains('error')) {
                    formGroup.classList.remove('error');
                    document.getElementById(`${fieldName}Error`).textContent = '';
                }
            });
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!validateForm()) {
                showToast('Please fix all errors before submitting', 'error');
                return;
            }

            const formData = {
                fname: formInputs.fname.value.trim(),
                lname: formInputs.lname.value.trim(),
                username: formInputs.username.value.trim(),
                gender: formInputs.gender.value,
                age: formInputs.age.value,
                email: formInputs.email.value.trim(),
                cnumber: formInputs.cnumber.value.trim(),
                password: formInputs.password.value
            };

            const submitBtn = document.querySelector('.btn-primary');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';

            showToast('Processing registration...', 'warning');

            try {
                const response = await fetch('process_admin_reg.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    showToast(result.message, 'success');
                    form.reset();
                    clearValidationStates();
                    
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'admin.php';
                    }, 2000);
                } else {
                    showToast(result.message, 'error');
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
        });

        form.addEventListener('reset', () => {
            clearValidationStates();
            showToast('Form cleared', 'warning');
        });
    </script>
</body>
</html>