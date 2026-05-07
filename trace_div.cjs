const fs = require('fs');
const html = fs.readFileSync('resources/views/dashboard.blade.php', 'utf8');
let depth = 0;
let lines = html.split('\n');
let inside = false;
let startLine = 0;

for(let i=0; i<lines.length; i++) {
    if(lines[i].includes('x-data="timerApp') && !inside) {
        startLine = i + 1;
        inside = true;
    }
    
    if(inside) {
        let openCount = (lines[i].match(/<div/g) || []).length;
        let closeCount = (lines[i].match(/<\/div>/g) || []).length;
        depth += openCount;
        depth -= closeCount;
        
        if (depth === 0 && i > startLine) {
            console.log('timerApp started at', startLine, 'and closed at', i+1);
            break;
        }
    }
}
