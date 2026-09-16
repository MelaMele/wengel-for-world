const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);

// CORS ፍቃድ ለሁሉም ምዕመናን እና ፓስተሮች
const io = new Server(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"]
  }
});

app.get('/', (req, res) => {
  res.send('Wengel for World - In-House Media Streaming Server is Active!');
});

// የክፍሎች እና የተጠቃሚዎች ግንኙነት
io.on('connection', (socket) => {
  console.log('User connected:', socket.id);

  // ፓስተሩ ወይም ምዕመኑ ክፍል ሲቀላቀሉ
  socket.on('join-room', (roomId, userId) => {
    socket.join(roomId);
    socket.to(roomId).emit('user-connected', userId);

    socket.on('disconnect', () => {
      socket.to(roomId).emit('user-disconnected', userId);
    });
  });

  // WebRTC Signaling (ቪዲዮና ድምፅ ማስተላለፊያ ትዕዛዞች)
  socket.on('signal', (data) => {
    io.to(data.room).emit('signal', {
      from: socket.id,
      signal: data.signal
    });
  });
});

const PORT = process.env.PORT || 8080;
server.listen(PORT, () => {
  console.log(`Media Server running on port ${PORT}`);
});
