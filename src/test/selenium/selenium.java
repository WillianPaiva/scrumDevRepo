import junit.framework.Test;
import junit.framework.TestSuite;

public class Selenium {

  public static Test suite() {
    TestSuite suite = new TestSuite();
    suite.addTestSuite(register.class);
    suite.addTestSuite(login.class);
    suite.addTestSuite(projcre.class);
    suite.addTestSuite(baklog.class);
    suite.addTestSuite(addtask.class);
    suite.addTestSuite(kanban.class);
    return suite;
  }

  public static void main(String[] args) {
    junit.textui.TestRunner.run(suite());
  }
}
