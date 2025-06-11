<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Robotors</title>   
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", sans-serif;
    }

    body{
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(#EEEEFF, #C8C7FF);
    }

    .chatbot-popup {
      position: relative;
      width: 420px;
      background: #fff;
      overflow: hidden;
      border-radius: 15px;
      box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1), 0 32px 64px -48px rgba(0, 0, 0, 0.5);
    }

    .chat-header {
      display: flex;
      align-items: center;
      background: #5350C4;
      padding: 15px 22px;
      justify-content: space-between;
    }

    .chat-header .header-info{
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .header-info .chatbot-logo{
      height: 35px;
      width: 35px;
      padding: 6px;
      fill: #5350C4;
      flex-shrink: 0;
      background: #fff;
      border-radius: 50%;
    }

    .header-info .logo-text{
      color: #fff;
      font-size: 1.31rem;
      font-weight: 600;
    }

    .chat-header #close-chatbot{
      border: none;
      color: #fff;
      height: 40px;
      width: 40px;
      font-size: 1.9rem;
      margin-right: -10px;
      padding-top: 2px;
      cursor: pointer;
      border-radius: 50%;
      background: none;
      transition: 0.2s ease;
    }

    .chat-header #close-chatbot:hover {
      background: #3d39ac;
    }

    .chat-body{ /**ubah tinggi body**/
      padding: 25px 22px;
      display: flex;
      gap: 20px;
      height: 460px;
      margin-bottom: 82px;
      overflow-y: auto;
      flex-direction: column;
      scrollbar-width: thin;
      scrollbar-color: #ccccf5 transparent;
    }

    .chat-body .message{
      display: flex;
      gap: 11px;
      align-items: center;
    }

    .chat-body .bot-message .bot-avatar{
      height: 35px;
      width: 35px;
      padding: 6px;
      fill: #fff;
      align-self: flex-end;
      flex-shrink: 0;
      margin-bottom: 2px;
      background: #5350C4;
      border-radius: 50%;
    }

    .chat-body .user-message {
      flex-direction: column;
      align-items: flex-end;
    }

    .chat-body .message .message-text{
      padding: 12px 16px;
      max-width: 75%;
      font-size: 0.95rem;
      
    }

    .chat-body .bot-message.thinking .message-text{
      padding: 2px 16px;
    }

    .chat-body .bot-message .message-text{
      background: #cbcbde;
      border-radius: 13px 13px 13px 3px;
    }

    .chat-body .user-message .message-text{
      color: #fff;
      background: #5350C4;
      border-radius: 13px 13px 3px 13px ;
    }

     .chat-body .bot-message .thinking-indicator {
      display: flex;
      gap: 4px;
      padding-block: 15px;

      
    }

    .chat-body .bot-message .thinking-indicator .dot{
      height: 7px;
      width: 7px;
      opacity: 0.7;
      border-radius: 50%;
      background: #6f6bc2;
      animation: dotPulse 1.8s ease-in-out infinite;

    }

    .chat-body .bot-message .thinking-indicator .dot:nth-child(1) {
      animation-delay: 0.2s;
    }

    .chat-body .bot-message .thinking-indicator .dot:nth-child(2) {
      animation-delay: 0.3s;
    }

    .chat-body .bot-message .thinking-indicator .dot:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes dotPulse {
      0%, 44% {
        transform: translateY(0);
      }

      28% {
        opacity: 0.4;
        transform: translateY(-4px);
      }

       44% {
        opacity: 0.2;
      }
    }

    .chat-footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      background:#fff;
      padding: 15px 22px 20px;
    }

    .chat-footer .chat-form {
      display: flex;
      align-items: center;
      background:#fff;
      border-radius: 32px;
      outline: 1px solid #cccce5;
    }

    .chat-footer .chat-form:focus-within{
      outline: 2px solid #5350C4;
    }

    .chat-form .message-input {
      border: none;
      outline: none;
      height: 47px;
      width: 100%;
      resize: none;
      font-size: 0.95rem;
      padding: 14px 0 13px 18px;
      border-radius: inherit;
    }

     .chat-form .chat-controls{
      display: flex;
      height: 47px;
      gap: 3px;
      align-items: center;
      align-self: flex-end;
      padding-right: 6px;
     }

     .chat-form .chat-controls button{
      height: 35px;
      width: 35px;
      font-size: 1.15rem;
      border: none;
      cursor: pointer;
      color: #706DB0;
      background: none;
      border-radius: 50%;
      transition: 0.02s ease;
     }

     .chat-form .chat-controls #send-message{
      color: #fff;
      display: none;
      background: #5350C4;
     }

     .chat-form .message-input:valid~.chat-controls #send-message{
      display: block;
     }

     .chat-form .chat-controls #send-message:hover{
      background: #3d39ac;
     }


     .chat-form .chat-controls button:hover{
      background: #d5bdd4;
       }
  </style>
</head>

<body>
  <div class="chatbot-popup"> 
      <!--header-->
    <div class="chat-header">
        <div class="header-info">
          <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
              <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"></path>
          </svg>          
          <h2 class="logo-text">Robotors</h2>   
        </div>
        <button id="close-chatbot" class="material-symbols-rounded"> keyboard_arrow_left </button>
    </div>

    <!--body-->
        <div class="chat-body">
            <div class="message bot-message">
              <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
              <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"></path>
              </svg>          
              <div class="message-text">Halo👋<br> Ada yang bisa saya bantu?</div>
           </div>
      </div>

      <!--footer-->
      <div class="chat-footer">
        <form action="#" class="chat-form">
                    <textarea 
            name="message" 
            id="message-input" 
            placeholder="Ketik..." 
            class="message-input" 
            required
          ></textarea>
          <div class="chat-controls">
            
          <!--<button type="button" class="material-symbols-rounded">sentiment_satisfied</button>
            <button type="button" class="material-symbols-rounded">attach_file</button>-->
            <button type="submit"  id="send-message" class="material-symbols-rounded">arrow_upward</button>
          </div>
        </form>
      </div>
  </div>
  
  <script src="script.js"></script>
</body>
</html>