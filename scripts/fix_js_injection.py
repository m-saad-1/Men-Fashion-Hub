import re

file_path = "d:/xampp/htdocs/fashionhub/app/views/partials/header.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

bad_script = """    <script src="../../public/assets/js/auth.js">        // Mega menu hover logic for detached menu
        const trigger = document.querySelector('.mega-menu-trigger');
        const menu = document.getElementById('global-mega-menu');
        
        if (trigger && menu) {
            trigger.addEventListener('mouseenter', () => menu.classList.add('open'));
            trigger.addEventListener('mouseleave', () => menu.classList.remove('open'));
            menu.addEventListener('mouseenter', () => menu.classList.add('open'));
            menu.addEventListener('mouseleave', () => menu.classList.remove('open'));
        }
</script>"""

good_script = """    <script src="../../public/assets/js/auth.js"></script>"""

if bad_script in content:
    content = content.replace(bad_script, good_script)

good_js = """<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mega menu hover logic for detached menu
        const trigger = document.querySelector('.mega-menu-trigger');
        const menu = document.getElementById('global-mega-menu');
        
        if (trigger && menu) {
            trigger.addEventListener('mouseenter', () => menu.classList.add('open'));
            trigger.addEventListener('mouseleave', () => menu.classList.remove('open'));
            menu.addEventListener('mouseenter', () => menu.classList.add('open'));
            menu.addEventListener('mouseleave', () => menu.classList.remove('open'));
        }
    });
</script>
</body>"""

content = content.replace("</body>", good_js)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Fixed mega menu JS injection!")
