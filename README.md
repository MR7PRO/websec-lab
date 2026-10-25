# WebSec Lab v2 — مختبر أمن الويب

An Arabic/English interactive Web Security educational platform built for coursework demonstrations, featuring **60 bilingual questions** across six course topics.

## Features
- Side-by-side **SQL Injection educational simulation** using fictional data (not a real exploitable database).
- Browser-based encryption/decryption using **AES-256-GCM** and PBKDF2; demonstrate incorrect passwords without uploading data.
- Salt and hashing explanations (**SHA-256 demonstration is not suitable for password storage**; use bcrypt/Argon2id in real applications).
- Custom quizzes (5 / 10 / 20 / all questions), answer feedback, final result and TXT score export.
- Arabic RTL/English LTR, mobile responsive, no account registration or third-party analytics.

## Netlify deployment
Connect GitHub repository **MR7PRO/websec-lab** with Netlify using these settings:

| Setting | Value |
| --- | --- |
| Branch | `main` |
| Base directory | empty |
| Build command | empty |
| Publish directory | `site` |

The `netlify.toml` file already contains the publish configuration. The deployment uses `site/index.html` (standalone HTML with inlined CSS and JS). **No PHP runtime or database is required**.

## Local run
Open `site/index.html` or host using `python -m http.server 8080 -d site`. Browser Web Crypto requires HTTPS or localhost for secure context.

## Safety
Educational only. Do not test systems without explicit permission. The SQL injection lab is a simulation, not a real SQL backend. Do not enter real passwords into demonstrations. Quiz scores are for self-assessment, not official course grades.

## Status
Source uploaded to GitHub. Connect to Netlify to create a live URL, then test the live HTTPS site before submitting it to your instructor.
