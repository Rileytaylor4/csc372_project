/*
Name: Riley C. Taylor
Date: 2026-02-22
Description: Node.js server that serves static files from the public folder
*/

const http = require("http");
const fs = require("fs");
const path = require("path");

const PORT = 3000;
const publicDir = path.join(__dirname, "public");

// Determine correct content type
function getContentType(filePath) {
  const ext = path.extname(filePath).toLowerCase();

  switch (ext) {
    case ".html": return "text/html";
    case ".css": return "text/css";
    case ".js": return "application/javascript";
    case ".jpg":
    case ".jpeg": return "image/jpeg";
    case ".png": return "image/png";
    default: return "application/octet-stream";
  }
}

// Serve static files
function serveStaticFile(res, filePath) {
  fs.readFile(filePath, (err, data) => {
    if (err) {
      res.writeHead(500, { "Content-Type": "text/plain" });
      res.end("500 Internal Server Error");
    } else {
      res.writeHead(200, { "Content-Type": getContentType(filePath) });
      res.end(data);
    }
  });
}

http.createServer((req, res) => {

  // Normalize URL
  let requestedPath = req.url.split("?")[0].toLowerCase();
  if (requestedPath.endsWith("/")) {
    requestedPath = requestedPath.slice(0, -1);
  }

  if (requestedPath === "") {
    requestedPath = "/";
  }

  // Map URL to file
  let filePath;
  if (requestedPath === "/") {
    filePath = path.join(publicDir, "index.html");
  } else {
    filePath = path.join(publicDir, requestedPath + ".html");
  }

  // If file exists, serve it. Otherwise serve 404 page.
  fs.access(filePath, fs.constants.F_OK, (err) => {
    if (err) {
      const notFoundPath = path.join(publicDir, "404.html");
      fs.readFile(notFoundPath, (error, data) => {
        res.writeHead(404, { "Content-Type": "text/html" });
        res.end(data);
      });
    } else {
      serveStaticFile(res, filePath);
    }
  });

}).listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});