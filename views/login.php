<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Conference Scheduler</title>
    <link rel="stylesheet" href="views/styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
        }

        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .auth-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }

        .auth-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }

        .auth-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group:last-of-type {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f7fafc;
            color: #2d3748;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .submit-btn {
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            padding: 0 30px 30px 30px;
            border-top: 1px solid #e2e8f0;
        }

        .auth-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .auth-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .auth-text {
            color: #718096;
            font-size: 0.95rem;
            margin: 0;
        }

        .error-message {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: shake 0.5s ease-in-out;
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message::before {
            content: "✕ ";
            font-weight: 700;
            margin-right: 8px;
        }

        .divider {
            text-align: center;
            margin: 30px 0 25px 0;
            position: relative;
            color: #cbd5e0;
        }

        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #cbd5e0;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        @media (max-width: 480px) {
            .auth-card {
                border-radius: 12px;
            }

            .auth-header {
                padding: 30px 20px;
            }

            .auth-body {
                padding: 30px 20px;
            }

            .auth-footer {
                padding: 0 20px 20px 20px;
            }

            .auth-title {
                font-size: 1.5rem;
            }

            .auth-icon {
                font-size: 2.5rem;
                margin-bottom: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">🔐</div>
                <h1 class="auth-title">Đăng Nhập</h1>
                <p class="auth-subtitle">Truy cập tài khoản của bạn</p>
            </div>

            <div class="auth-body">
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="post" action="index.php?page=login">
                    <div class="form-group">
                        <label for="email" class="form-label">📧 Địa chỉ Email</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            class="form-input"
                            placeholder="your@email.com"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">🔒 Mật Khẩu</label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-input"
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <button type="submit" class="submit-btn">Đăng Nhập</button>
                </form>

                <div class="divider"></div>
            </div>

            <div class="auth-footer">
                <p class="auth-text">Chưa có tài khoản? 
                    <a href="index.php?page=register" class="auth-link">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
