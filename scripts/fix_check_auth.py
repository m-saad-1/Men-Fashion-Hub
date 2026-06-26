import os

directory = "d:/xampp/htdocs/fashionhub/public/pages"
files = [f for f in os.listdir(directory) if f.endswith('.php')]

for file in files:
    file_path = os.path.join(directory, file)
    try:
        with open(file_path, "r", encoding="utf-8") as f:
            content = f.read()

        new_content = content.replace("check_auth.php", "auth/validate_session.php")

        if new_content != content:
            with open(file_path, "w", encoding="utf-8") as f:
                f.write(new_content)
            print(f"Updated {file}")
    except Exception as e:
        print(f"Error on {file}: {e}")
