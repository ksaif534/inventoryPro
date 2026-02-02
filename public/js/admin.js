import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize Alpine data and components
Alpine.data('confirmDialog', () => ({
    show: false,
    message: '',
    onConfirm: null,
    
    confirm(message, callback) {
        this.message = message;
        this.show = true;
        this.onConfirm = callback;
    },
    
    yes() {
        this.show = false;
        if (this.onConfirm) this.onConfirm();
    },
    
    no() {
        this.show = false;
        this.onConfirm = null;
    }
}));

Alpine.data('dataTable', (url = null, filters = {}) => ({
    loading: false,
    items: [],
    pagination: {
        current_page: 1,
        last_page: 1,
        per_page: 15,
        total: 0,
    },
    filters: filters,
    search: '',
    
    init() {
        this.loadItems();
    },
    
    async loadItems() {
        this.loading = true;
        
        const params = new URLSearchParams({
            page: this.pagination.current_page,
            search: this.search,
            ...this.filters
        });
        
        try {
            const response = await fetch(`${url}?${params}`);
            const data = await response.json();
            
            this.items = data.data;
            this.pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                per_page: data.per_page,
                total: data.total,
            };
        } catch (error) {
            console.error('Error loading items:', error);
        } finally {
            this.loading = false;
        }
    },
    
    nextPage() {
        if (this.pagination.current_page < this.pagination.last_page) {
            this.pagination.current_page++;
            this.loadItems();
        }
    },
    
    prevPage() {
        if (this.pagination.current_page > 1) {
            this.pagination.current_page--;
            this.loadItems();
        }
    },
    
    goToPage(page) {
        this.pagination.current_page = page;
        this.loadItems();
    },
    
    searchItems() {
        this.pagination.current_page = 1;
        this.loadItems();
    }
}));

Alpine.data('chart', (type = 'line', data = null, options = {}) => ({
    chartInstance: null,
    
    init() {
        // Simple chart initialization
        // In a real app, you'd use a charting library like Chart.js
        this.initChart();
    },
    
    initChart() {
        const ctx = this.$el.getContext('2d');
        
        // Simple bar chart implementation
        if (type === 'bar') {
            this.drawBarChart(ctx, data);
        } else if (type === 'line') {
            this.drawLineChart(ctx, data);
        }
    },
    
    drawBarChart(ctx, data) {
        // Simplified bar chart drawing
        const width = ctx.canvas.width;
        const height = ctx.canvas.height;
        const maxValue = Math.max(...data.values);
        const barWidth = width / data.labels.length * 0.6;
        const spacing = width / data.labels.length * 0.4;
        
        ctx.clearRect(0, 0, width, height);
        
        data.values.forEach((value, index) => {
            const barHeight = (value / maxValue) * (height - 40);
            const x = index * (barWidth + spacing) + spacing / 2;
            const y = height - barHeight - 20;
            
            // Create gradient
            const gradient = ctx.createLinearGradient(0, y, 0, height - 20);
            gradient.addColorStop(0, '#06b6d4');
            gradient.addColorStop(1, '#a855f7');
            
            ctx.fillStyle = gradient;
            ctx.fillRect(x, y, barWidth, barHeight);
            
            // Draw value
            ctx.fillStyle = '#ffffff';
            ctx.font = '12px Inter';
            ctx.textAlign = 'center';
            ctx.fillText(value, x + barWidth / 2, y - 5);
            
            // Draw label
            ctx.fillText(data.labels[index], x + barWidth / 2, height - 5);
        });
    },
    
    drawLineChart(ctx, data) {
        // Simplified line chart drawing
        const width = ctx.canvas.width;
        const height = ctx.canvas.height;
        const maxValue = Math.max(...data.values);
        const spacing = width / (data.labels.length - 1);
        
        ctx.clearRect(0, 0, width, height);
        
        // Draw line
        ctx.beginPath();
        ctx.strokeStyle = '#06b6d4';
        ctx.lineWidth = 2;
        
        data.values.forEach((value, index) => {
            const x = index * spacing;
            const y = height - ((value / maxValue) * (height - 40)) - 20;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
        
        // Draw points
        data.values.forEach((value, index) => {
            const x = index * spacing;
            const y = height - ((value / maxValue) * (height - 40)) - 20;
            
            ctx.beginPath();
            ctx.fillStyle = '#a855f7';
            ctx.arc(x, y, 4, 0, Math.PI * 2);
            ctx.fill();
            
            // Draw value
            ctx.fillStyle = '#ffffff';
            ctx.font = '12px Inter';
            ctx.textAlign = 'center';
            ctx.fillText(value, x, y - 10);
        });
    }
}));

Alpine.data('imageUpload', (maxSize = 2048) => ({
    file: null,
    preview: null,
    uploading: false,
    
    handleFileSelect(event) {
        const selectedFile = event.target.files[0];
        
        if (!selectedFile) {
            return;
        }
        
        // Validate file size
        if (selectedFile.size > maxSize * 1024) {
            alert(`File size must be less than ${maxSize}KB`);
            event.target.value = '';
            return;
        }
        
        // Validate file type
        if (!selectedFile.type.startsWith('image/')) {
            alert('Please select an image file');
            event.target.value = '';
            return;
        }
        
        this.file = selectedFile;
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            this.preview = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    },
    
    removeFile() {
        this.file = null;
        this.preview = null;
        const input = this.$el.querySelector('input[type="file"]');
        if (input) input.value = '';
    }
}));

// Utility functions
window.utils = {
    formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    },
    
    formatDate(date) {
        return new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }).format(new Date(date));
    },
    
    formatDateTime(date) {
        return new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    },
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};

// Start Alpine
Alpine.start();