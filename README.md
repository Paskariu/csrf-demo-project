# CSRF Angriffsdemo

Dieses Projekt demonstriert Cross-Site Request Forgery (CSRF) Schwachstellen und deren effektive Gegenmaßnahmen anhand von zwei Versionen einer Banking-Webanwendung.

Unter vulnerable befindet sich eine ungeschützte Version der Anwendung, unter protected eine geschützte und unter attacker eine Angriffsseite.

## Projekt starten

### Voraussetzung

- Docker Desktop oder Docker Engine
- Docker Compose

**Schnellstart unter Windows:**

```powershell
cd <path-to-project>
.\start-demo.bat
.\stop-demo.bat
```

**Manuell mit Docker Compose:**

1. **Container bauen und starten**:

   ```powershell
   cd c:\Repos-master\csrf
   docker-compose up -d
   ```

2. **Anwendungen im Browser aufrufen**:

   - Anfällige Bank: `http://localhost:8080/login.php`
   - Geschützte Bank: `http://localhost:8081/login.php`
   - Angriffs-Demo: `http://localhost:8082/index.html`

3. **Container stoppen**:
   ```powershell
   docker-compose down
   ```

# Angriffszenario

Zuerst müssen Sie sich mit den angegebenen Daten bei der unsicheren und sicheren Bank anmelden; eine echte Datenbank gibt es nicht, es soll nur einen angemeldeten Nutzer simulieren.

Anschließend können über die Angreiferseite zwei Angriffe durchgeführt werden. Bei aktualisieren der Bankseiten werden die Angriffe sichtbar.