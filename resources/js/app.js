import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Theme toggle functionality
Alpine.store('darkMode', {
    isDark: localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    
    init() {
        this.applyTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('darkMode')) {
                this.isDark = e.matches;
                this.applyTheme();
            }
        });
    },
    
    toggle() {
        this.isDark = !this.isDark;
        localStorage.setItem('darkMode', this.isDark);
        this.applyTheme();
    },
    
    applyTheme() {
        if (this.isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

Alpine.start();
