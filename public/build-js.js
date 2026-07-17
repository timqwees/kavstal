const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const files = [
  ['public/assets/scripts/main/catalog-home.js', 'public/assets/scripts/main/catalog-home.min.js'],
  ['public/assets/scripts/main/product.js', 'public/assets/scripts/main/product.min.js'],
  ['public/assets/scripts/main/stories.js', 'public/assets/scripts/main/stories.min.js'],
  ['public/assets/scripts/main/switchUnit.js', 'public/assets/scripts/main/switchUnit.min.js'],
  ['public/assets/scripts/main/header.js', 'public/assets/scripts/main/header.min.js'],
];

const componentsDir = 'public/assets/scripts/components';
fs.readdirSync(componentsDir).forEach(f => {
  if (f.endsWith('.js') && !f.endsWith('.min.js')) {
    const min = f.replace('.js', '.min.js');
    if (fs.existsSync(path.join(componentsDir, min))) {
      files.push([path.join(componentsDir, f), path.join(componentsDir, min)]);
    }
  }
});

files.forEach(([src, dest]) => {
  if (fs.existsSync(src)) {
    try {
      execSync(`npx terser "${src}" -c -m -o "${dest}"`);
      console.log(`  ${src} -> ${dest}`);
    } catch (e) {
      console.error(`  FAILED: ${src}: ${e.message}`);
    }
  }
});

console.log('JS build complete.');
