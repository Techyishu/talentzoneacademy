# Deployment Fix Instructions

The hero section is not showing on the live site because the compiled CSS/JS assets (where the new styles live) are inside `public/build`, which is ignored by Git (as seen in your `.gitignore`).

When you pulled the changes on the server, you only got the code, not the built assets. Since you are on shared hosting, you likely cannot run `npm run build` directly on the server.

## Steps to Fix

1.  **Build Locally**:
    Run this in your **local** terminal (not the SSH one):
    ```bash
    npm run build
    ```

2.  **Upload Assets**:
    Upload the `public/build` folder from your local machine to the `public` folder on your server.
    You can use SCP (run this locally):
    ```bash
    # Replace 'your-domain.com' with your actual domain folder name
    scp -P 65002 -r public/build u319212273@145.79.213.110:./domains/your-domain.com/public_html/public/
    ```
    *(Alternatively, use an FTP client like FileZilla to upload the `public/build` folder).*

3.  **Clear Cache on Server**:
    In your **SSH terminal** (on the server), run:
    ```bash
    php artisan view:clear
    php artisan cache:clear
    ```

Once these steps are completed, refresh your website, and the new hero section should appear.
