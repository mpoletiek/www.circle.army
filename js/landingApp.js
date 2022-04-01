landingApp = {
    web3Provider: null,
    accounts: [],
    connected: false,
    web3: null,
    chainId: null,
    acceptedNetworks: [ 137 ],
    networkAccepted: false,
    esJsonData: null,
    maticPrice: null,
    latestTXHash: null,
    challenge: null,
    footerInsertRight: document.getElementById('footer-insert-right'),
    //loginChallenge: document.getElementById('challenge_id').innerHTML,
    

    // This is the first function called. Here we can setup stuff needed later
    init: async function() {
        // Show loading spinner
        landingApp.loadingSpinner(true);
        //$('#footer-insert-right').text('WEEEEEEEE');

        return await landingApp.initWeb3();
    },
  
    // Initialize Web3
    initWeb3: async function() {
  
        // First we check to see which type of Web3 we're using.
      // Modern dapp browsers...
      if (window.ethereum){
        try {
          //Request account access
          landingApp.accounts = await window.ethereum.request({ method: "eth_requestAccounts" });
          landingApp.connected = true;
        } catch (error) {
          // User denied account access...
          console.error("User denied account access");
          landingApp.connected = false;
          // Set proper message on UI
          $('#status-text').text("Wallet Declined");
          return landingApp.loadingSpinner(false);
        }
        
        // User granted access to accounts
        console.log("Account[0]: "+landingApp.accounts[0]);
        
        landingApp.web3Provider = window.ethereum;
        console.log("modern dapp browser");
      }
      // Legacy dapp browsers...
      else if (window.web3) {
          try {
            landingApp.web3Provider = window.web3.currentProvider;
            landingApp.accounts = window.eth.accounts;
            console.log("legacy dapp browser");
          } catch (error) {
              console.error("User denied account access");
              landingApp.connected = false;
              $('#status-text').text("Wallet Declined");
              return landingApp.loadingSpinner(false);
          }
        
      }
      else{
          // Failed to connect to wallet or wallet account access denied
          landingApp.connected = false;
      }

      // Initialize Web3
      if(landingApp.connected){
        landingApp.web3 = new Web3(landingApp.web3Provider);
        // Get current Blockchain Network and check if we accept
        landingApp.chainId = await landingApp.web3.eth.net.getId();
        console.log("Chain ID: "+landingApp.chainId);

        if(landingApp.acceptedNetworks.includes(landingApp.chainId)){
            console.log("Valid Blockchain Network");
            landingApp.networkAccepted = true;
        }
        
        console.log("landingApp.connected: "+landingApp.connected);

        return landingApp.walletConnected();
        //return App.drawDonateForm();
      }
      else{
        return landingApp.loadingSpinner(false);
        //return App.drawWalletOptions();
          
      }

    },

    walletConnected: function() {
      landingApp.loadingSpinner(false);
      // Query the login db for the user
      // get the sign-in key.

      return true;
    },
    
    loadingSpinner: function(show) {
        if(show == true){
            $('#loading-spinner').show();
        }
        else{
            $('#loading-spinner').hide();
        }
    }
}

// Execute the app when the DOM is ready
$(function() {
    $(document).ready(function() {
        landingApp.init();
    });
});