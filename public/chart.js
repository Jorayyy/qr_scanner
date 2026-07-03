/* Standalone Graphical Chart Layout Grid Render Engine v1.2 */
window.Chart = class {
    constructor(canvas, configuration) {
        this.ctx = canvas.getContext ? canvas.getContext('2d') : canvas;
        this.config = configuration;
        this.render();
    }
    render() {
        const type = this.config.type;
        const data = this.config.data;
        
        // Setup scaling bounds
        this.ctx.clearRect(0, 0, 600, 300);
        this.ctx.font = 'bold 11px sans-serif';
        
        if (type === 'bar') {
            // Draw baseline axes
            this.ctx.strokeStyle = '#e2e8f0';
            this.ctx.lineWidth = 1;
            this.ctx.beginPath();
            this.ctx.moveTo(30, 170);
            this.ctx.lineTo(250, 170);
            this.ctx.stroke();

            let currentX = 45;
            const labels = data.labels || [];
            const values = data.datasets[0].data || [];
            
            if (labels.length === 0) {
                this.ctx.fillStyle = '#94a3b8';
                this.ctx.fillText('No traffic data logged yet', 50, 100);
                return;
            }

            labels.forEach((label, index) => {
                // Draw individual bar data block columns
                this.ctx.fillStyle = '#0f172a';
                let rawValue = values[index] || 0;
                let barHeight = Math.min(rawValue * 40, 130);
                
                // Rounded corner bar drawing matrix
                this.ctx.beginPath();
                this.ctx.roundRect(currentX, 170 - barHeight, 30, barHeight, 5);
                this.ctx.fill();

                // Draw values above the bar columns
                this.ctx.fillStyle = '#0f172a';
                this.ctx.fillText(rawValue, currentX + 10, 165 - barHeight);
                
                // Draw base text titles
                this.ctx.fillStyle = '#64748b';
                this.ctx.font = '9px sans-serif';
                // Shorten date format strings if they are too long
                let shortLabel = label.includes('-') ? label.split('-').slice(1).join('/') : label;
                this.ctx.fillText(shortLabel, currentX - 2, 185);
                currentX += 60;
            });
        } else if (type === 'pie') {
            const labels = data.labels || [];
            const datasetValues = data.datasets[0].data || [];
            const colors = ['#10b981', '#64748b', '#f59e0b'];
            
            let total = datasetValues.reduce((a, b) => a + b, 0);
            let currentAngle = -Math.PI / 2; 
            
            // Draw Pie Segments
            datasetValues.forEach((val, idx) => {
                if (val === 0 && total > 0) return;
                let sliceAngle = total === 0 ? (Math.PI * 2) / 3 : (val / total) * Math.PI * 2;
                
                this.ctx.fillStyle = colors[idx] || '#cbd5e1';
                this.ctx.beginPath();
                this.ctx.moveTo(80, 95);
                this.ctx.arc(80, 95, 65, currentAngle, currentAngle + sliceAngle);
                this.ctx.closePath();
                this.ctx.fill();
                
                currentAngle += sliceAngle;
            });

            // Draw Clean Side Labels Legend List
            let legendY = 35;
            labels.forEach((label, idx) => {
                let val = datasetValues[idx] || 0;
                
                // Colored status indicator block boxes
                this.ctx.fillStyle = colors[idx];
                this.ctx.fillRect(170, legendY - 8, 10, 10);
                
                // Context descriptive labels
                this.ctx.fillStyle = '#334155';
                this.ctx.font = '11px sans-serif';
                this.ctx.fillText(`${label}: ${val}`, 190, legendY);
                legendY += 25;
            });
        }
    }
};
