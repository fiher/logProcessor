# Log Processor
Coding task for processing of logs

## Getting Started
- Make sure you have Docker installed and running
- You can run `docker-compose exec -t php bin/console log:import-data` to import data
- To start the container you can do `docker compose up`
- API implementation should follow the yaml file design with a GET `/count` endpoint
- Additional endpoint DELETE `/detele` exists for easier development

## Design Choices
- Used FrankenPHP template I found online for easier setup and to save time.
- Added interfaces for every dependency so that the implementations could easily be swapped
- All dependencies could be passed down for easier testing, even if they are static (LogValidator)
- Added a delete method for easier development

## Future Improvements
 
Obviously I have made some sacrifices in the name of simplicity. So it should be noted what I know can be done better.

- Using a setup with Kubernetes can make it easier to deploy and create multiple pods to work at the same time.
- Split the logic of importing logs and dumping in the db and the REST API. Those ideally should be separate deployments.
- Adding more complex worker setup to process logs more efficiently, especially if we have trillions of logs
- Probably worth looking into implementing an event based solution.
- Adding more tests would have been better, especially with more complicated inputs like tricky date situations. 
I didn't want to invest too much time in this project to that was one area I had to sacrifice.
- More validations for tricky data inputs, supporting more date formats, and clearer documentation on what data formats are supported would have been a good addition.

Overall I have made choices similar to those I would have in a real work environment where time is tight. 
Documentation and Testing are sacrificed, for the name of following good design paradigms that also make testing easier in the future. 
Additionally, scalability comes second as I treat this more as a POC or MVP.