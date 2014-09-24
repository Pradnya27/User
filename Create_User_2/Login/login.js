  window.onload = function() {
                document.getElementById('fpass').onchange = disablefield;
            };
            function disablefield()
            {
                if (document.getElementById('fpass').checked === true)
                {                 
                   
                    document.getElementById('forget_password').disabled = false;
                    document.getElementById('user_id').disabled = true;
                    document.getElementById('password').disabled = true;
                    document.getElementById('submit').disabled = true;
                }
                else
                {
                    document.getElementById('fpass').checked =false;
                    document.getElementById('forget_password').disabled = true;
                    document.getElementById('user_id').disabled = false;
                    document.getElementById('password').disabled = false;
                    document.getElementById('submit').disabled = false;
                }
            }
