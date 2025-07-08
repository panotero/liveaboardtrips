<style>
    /* General Styles */
    .lytbox-container {
        position: relative;
        z-index: 101;
    }

    /* Hide checkbox */
    .lytbox-checkbox {
        display: none;
    }

    /* Hamburger Menu Button */
    .lytbox-button {
        --hamburger-color: #000;
        display: block;
        height: 24px;
        cursor: pointer;
        position: relative;
        z-index: 102;
        background: none;
        border: none;
        outline: none;
        padding: 0;
    }

    .lytbox-button .hamburguer {
        position: relative;
        width: 30px;
        height: 18px;
    }

    .lytbox-button .hamburguer span {
        display: block;
        height: 3px;
        width: 100%;
        background: var(--hamburger-color);
        margin: 3px 0;
        transition: all 0.3s ease;
    }

    /* Navigation Menu */
    .lytbox-navigation {
        position: fixed;
        top: 0;
        right: -100%;
        /* Hidden initially */
        width: 100%;
        height: 100vh;
        background: #fff;
        /* Background color */
        z-index: 100;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: right 0.3s ease;
        /* Smooth sliding effect */
        overflow: hidden;
        margin: 0;
        /* Remove any default margins */
        padding: 0;
        /* Remove any default padding */
        box-sizing: border-box;
        /* Include borders and padding in width/height */
    }

    /* Navigation Close Button */
    .nav-close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        z-index: 102;
    }

    /* Open Navigation with :checked */
    .lytbox-checkbox:checked~.lytbox-navigation {
        right: 0;
    }

    /* Change Hamburger to Cross when menu is open */
    .lytbox-checkbox:checked+.lytbox-button .hamburguer span:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }

    .lytbox-checkbox:checked+.lytbox-button .hamburguer span:nth-child(2) {
        opacity: 0;
    }

    .lytbox-checkbox:checked+.lytbox-button .hamburguer span:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }
</style>