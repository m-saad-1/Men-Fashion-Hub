import re

file_path = "d:/xampp/htdocs/fashionhub/app/views/partials/header.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Extract mega menu HTML
mega_menu_match = re.search(r'(<div class="mega-menu">.*?</nav>)', content, re.DOTALL)
if mega_menu_match:
    # Actually, we need exactly the mega-menu div.
    # It starts at <div class="mega-menu">
    # and ends at the </div> right before </li>
    mega_menu_html = re.search(r'(<div class="mega-menu">.*?</div>\s*)\s*</li>\s*<li><a href="about.php"', content, re.DOTALL)
    
    if mega_menu_html:
        extracted = mega_menu_html.group(1)
        
        # Remove it from original position
        content = content.replace(extracted, "")
        
        # Insert it before </header>
        # And make sure it has an ID so JS can target it easily
        extracted_with_id = extracted.replace('<div class="mega-menu">', '<div class="mega-menu" id="global-mega-menu">')
        
        content = content.replace('</header>', extracted_with_id + '\n    </header>')
        
        # Add JavaScript to handle hover
        js_to_add = """        // Mega menu hover logic for detached menu
        const trigger = document.querySelector('.mega-menu-trigger');
        const menu = document.getElementById('global-mega-menu');
        
        if (trigger && menu) {
            trigger.addEventListener('mouseenter', () => menu.classList.add('open'));
            trigger.addEventListener('mouseleave', () => menu.classList.remove('open'));
            menu.addEventListener('mouseenter', () => menu.classList.add('open'));
            menu.addEventListener('mouseleave', () => menu.classList.remove('open'));
        }
"""
        # Inject JS before </script>
        content = content.replace('</script>', js_to_add + '</script>')
        
        with open(file_path, "w", encoding="utf-8") as f:
            f.write(content)
        print("Successfully moved mega menu!")
    else:
        print("Could not isolate mega menu div")
else:
    print("Could not find mega menu block")
