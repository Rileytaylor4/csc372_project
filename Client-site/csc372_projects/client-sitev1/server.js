/*
Name: Riley C. Taylor
Date: 2026-02-22
Description: Node.js HTTP server that serves static files from the public folder with a custom 404 page.
*/

const http = require("http");
const fs = require("fs");
const path = require("path");

const PORT = process.env.PORT || 3000;
const publicDir = path.join(__dirname, "public");

function getContentType(filePath) {
  const ext = path.extname(filePath).toLowerCase();

  switch (ext) {
    case ".html": return "text/html; charset=utf-8";
    case ".css": return "text/css; charset=utf-8";
    case ".js": return "application/javascript; charset=utf-8";
    case ".json": return "application/json; charset=utf-8";
    case ".png": return "image/png";
    case ".jpg":
    case ".jpeg": return "image/jpeg";
    case ".gif": return "image/gif";
    case ".webp": return "image/webp";
    case ".svg": return "image/svg+xml";
    case ".ico": return "image/x-icon";
    case ".woff": return "font/woff";
    case ".woff2": return "font/woff2";
    case ".ttf": return "font/ttf";
    default: return "application/octet-stream";
  }
}

// Reads a file and sends it with the correct Content-Type.
// - statusCode 200 when successful
// - statusCode 500 if a server error occurs
function serveStaticFile(res, filePath, statusCode = 200) {
  fs.readFile(filePath, (err, data) => {
    if (err) {
      res.writeHead(500, { "Content-Type": "text/plain; charset=utf-8" });
      res.end("500 Internal Server Error");
      return;
    }

    res.writeHead(statusCode, { "Content-Type": getContentType(filePath) });
    res.end(data);
  });
}

http.createServer((req, res) => {
  // Normalize URL path (remove query string, remove trailing slash, lowercase)
  let requestedPath = (req.url || "/").split("?")[0];

  try {
    requestedPath = decodeURIComponent(requestedPath);
  } catch {
    requestedPath = "/";
  }

  requestedPath = requestedPath.toLowerCase();

  if (requestedPath.length > 1 && requestedPath.endsWith("/")) {
    requestedPath = requestedPath.slice(0, -1);
  }

  // Map URL path to a file inside /public
  let relativePath;
  if (requestedPath === "/") {
    relativePath = "index.html";
  } else {
    const hasExtension = path.extname(requestedPath) !== "";
    relativePath = requestedPath.startsWith("/") ? requestedPath.slice(1) : requestedPath;

    // Support "pretty" routes like /services -> services.html
    if (!hasExtension) {
      relativePath += ".html";
    }
  }

  // Resolve to an absolute path and prevent directory traversal
  const filePath = path.resolve(publicDir, relativePath);
  if (!filePath.startsWith(path.resolve(publicDir))) {
    const notFoundPath = path.join(publicDir, "404.html");
    serveStaticFile(res, notFoundPath, 404);
    return;
  }

  // Check if the file exists; if not, serve custom 404 page
  fs.access(filePath, fs.constants.F_OK, (err) => {
    if (err) {
      const notFoundPath = path.join(publicDir, "404.html");

      fs.access(notFoundPath, fs.constants.F_OK, (nfErr) => {
        if (nfErr) {
          res.writeHead(404, { "Content-Type": "text/plain; charset=utf-8" });
          res.end("404 Page Not Found");
        } else {
          serveStaticFile(res, notFoundPath, 404);
        }
      });

      return;
    }

    serveStaticFile(res, filePath, 200);
  });
}).listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});