class MainScene extends Phaser.Scene {
    constructor() {
      super({ key: 'MainScene' });
      this.currentScore = 0;
      this.bestScore = 0;
    }
  
    preload() { /* charge tes assets ici */ }
  
    async create() {
      // 1) Récupérer et afficher le best existant
      const res = await fetch('/api/score');
      const scores = await res.json();
      this.bestScore = scores[0]?.value || 0;
  
      this.bestText  = this.add.text(20, 20, 'Best: ' + this.bestScore, { fontSize: '24px', color: '#fff' });
      this.scoreText = this.add.text(20, 50, 'Score: ' + this.currentScore, { fontSize: '24px', color: '#fff' });
  
      // 2) Configuration de ton joueur, plateformes, etc.
      // this.setupGame();
    }
  
    update() {
      // 3) Logique de score
      // ex: si le joueur monte, augmente score
      // if (player.y < lastY) { this.currentScore++; lastY = player.y; }
      this.scoreText.setText('Score: ' + this.currentScore);
    }
  
    async onGameOver() {
      await fetch('/api/score', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          player: 'Taha',
          value: this.currentScore
        })
      });
  
      const res2 = await fetch('/api/score');
      const top = await res2.json();
      this.bestScore = top[0]?.value || 0;
      this.bestText.setText('Best: ' + this.bestScore);
  
      this.add.text(300, 250, 'Game Over', { fontSize: '32px', color: '#f00' });
    }
  }
  