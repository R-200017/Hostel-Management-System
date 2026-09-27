<?php if($_SESSION['id'])
{ ?>
<div class="brand clearfix">
    <a href="dashboard.php" class="logo">
        <i class="fas fa-home"></i> Hostel Management System
    </a>
    <span class="menu-btn"><i class="fa fa-bars"></i></span>
    <ul class="ts-profile-nav">
        <li class="ts-account">
            <a href="#">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <span class="user-name"><?php echo $_SESSION['id']; ?></span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul>
                <li><a href="my-profile.php"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="change-password.php"><i class="fas fa-lock"></i> Change Password</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</div>

<style>
    .brand {
        background: linear-gradient(120deg, #4361ee, #7209b7);
        padding: 0 20px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }
    
    .logo {
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    
    .logo i {
        margin-right: 10px;
        font-size: 24px;
    }
    
    .menu-btn {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        display: none;
    }
    
    .ts-profile-nav {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
    }
    
    .ts-account {
        position: relative;
    }
    
    .ts-account > a {
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }
    
    .ts-account > a:hover {
        background: rgba(255, 255, 255, 0.15);
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-size: 20px;
    }
    
    .user-name {
        margin-right: 8px;
        font-weight: 500;
    }
    
    .ts-account ul {
        position: absolute;
        right: 0;
        top: 100%;
        background: #fff;
        width: 200px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        margin-top: 10px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }
    
    .ts-account:hover ul {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .ts-account ul li {
        list-style: none;
    }
    
    .ts-account ul li a {
        color: #495057;
        text-decoration: none;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .ts-account ul li a:hover {
        background: #f8f9fa;
        color: #4361ee;
    }
    
    .ts-account ul li a i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .menu-btn {
            display: block;
        }
        
        .user-name {
            display: none;
        }
        
        .ts-account > a {
            padding: 8px 12px;
        }
    }
</style>

<?php
} else { ?>
<div class="brand clearfix">
    <a href="index.php" class="logo">
        <i class="fas fa-home"></i> Hostel Management System
    </a>
    <span class="menu-btn"><i class="fa fa-bars"></i></span>
</div>

<style>
    .brand {
        background: linear-gradient(120deg, #4361ee, #7209b7);
        padding: 0 20px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .logo {
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    
    .logo i {
        margin-right: 10px;
        font-size: 24px;
    }
    
    .menu-btn {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        display: none;
    }
    
    @media (max-width: 768px) {
        .menu-btn {
            display: block;
        }
    }
</style>
<?php } ?>